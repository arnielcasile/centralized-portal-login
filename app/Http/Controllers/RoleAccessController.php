<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleAccessRequest;
use App\Interfaces\RoleAccessInterface;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;

class RoleAccessController extends Controller
{
    use ResponseAPI;
    protected $roleAccessInterface;

    /**
     * Constract the Interface to get Return Data
     * 
     * @param RoleAccessInterface $roleAccessInterface
     */
    public function __construct(RoleAccessInterface $roleAccessInterface)
    {
        $this->roleAccessInterface = $roleAccessInterface;
    }


    /**
     * Display all Role Access
     * 
     * @return error/success w/object data
     */
    public function load()
    {
        try {
            $result = $this->roleAccessInterface->loadAllRoleAccess();
            return $this->success("RoleAccess Loaded", 200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specific Role Access
     * The parameter used is coming from Routes API
     * 
     * @param $id
     * @return error/success w/object data
     */
    public function get($id)
    {
        try {
            $result = $this->roleAccessInterface->getSpecificRoleAccess($id);
            return $this->success("RoleAccess data Loaded", 200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Store the new Role Access
     * The parameter used is coming from RoleAccessRequest
     * 
     * @param RoleAccessRequest $request
     * @return warning/error/success true/false
     */
    public function store(RoleAccessRequest $request)
    {
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }
            $result = $this->roleAccessInterface->storeRoleAccess($request);
            return $this->success("RoleAccess added",200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Update the specific RoleAccess
     * The parameter used is coming from Routes API and RoleAccessRequest
     * 
     * @param RoleAccessRequest $request
     * @param $id
     * @return warning/error/success true/false
     */
    public function update(RoleAccessRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }
            $result = $this->roleAccessInterface->updateRoleAccess($request, $id);
            return $this->success("RoleAccess update",200, $result);
            DB::commit();
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
            DB::rollBack();
        }
    }

    /**
     * Remove the specific Role Access
     * The parameter used is coming from Routes API
     * 
     * @param $id
     * @return error/success true/false
     */
    public function delete($id)
    {
        try {
            $result = $this->roleAccessInterface->deleteRoleAccess($id);
            return $this->success("RoleAccess deleted",200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
