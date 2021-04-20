<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccessTokenRequest;
use App\Interfaces\AccessTokenInterface;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;

class AccessTokenController extends Controller
{
    use ResponseAPI;
    protected $accessTokenInterface;

    /**
     * Constract the Interface to get Return Data
     * 
     * @param AccessTokenInterface $accessTokenInterface
     */
    public function __construct(AccessTokenInterface $accessTokenInterface)
    {
        $this->accessTokenInterface = $accessTokenInterface;
    }

    /**
     * load all Access Token
     * 
     * @return error/success w/object data
     */
    public function load()
    {
        try {
            $result = $this->accessTokenInterface->loadAllAccessToken();
            return $this->success('AccessToken Loaded', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Get the Access Token
     * 
     * @param $id
     * @return error/success w/object data
     */
    public function get($id)
    {
        try {
            $result = $this->accessTokenInterface->getSpecificAccessToken($id);
            return $this->success('AccessToken data loaded', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }


    /**
     * Store the new created Accesss Token
     * 
     * @param AccessTokenRequest $request
     * @return error/success true/false
     */
    public function store(AccessTokenRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }
            $result = $this->accessTokenInterface->storeAccessToken($request->validated());
            return $this->success('AccessToken added', 200, $result);
            DB::commit();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
            DB::rollBack();
        }
    }

    /**
     * Update the AccessToken
     * 
     * @param AccessTokenRequest $request
     * @param $id
     * @return error/success true/false
     */
    public function update(AccessTokenRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }

            $result = $this->accessTokenInterface->updateAccessToken($id, $request->validated());
            return $this->success('AccessToken updated', 200, $result);
            DB::commit();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
            DB::rollBack();
        }
    }

    /**
     * Remove the Access Token
     * @param $id
     * @return error/success true/false
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result = $this->accessTokenInterface->deleteAccessToken($id);
            return $this->success('AccessToken deleted', 200, $result);
            DB::commit();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(),500);
            DB::rollBack();
        }
    }
}
