<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use App\Interfaces\ContactInterface;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    use ResponseAPI;
    protected $contactInterface;

    /**
     * Constract the Interface to get Return Data
     * 
     * @param ContactInterface $contactInterface
     */
    public function __construct(ContactInterface $contactInterface)
    {
        $this->contactInterface = $contactInterface;
    }

    /**
     * Load All Contacts from storage
     * 
     * @return error/success w/data object
     */
    public function load()
    {
        try {
            $result =  $this->contactInterface->loadAllContacts();
            return $this->success('Contacts Loaded', 200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Get the specific contacts from storage
     * 
     * @param $id
     * @return errror/success w/data object
     */
    public function get($id)
    {
        try {
            $result =  $this->contactInterface->getSpecificContacts($id);
            return $this->success('Contacts data Loaded', 200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Store the new Contacts in storage
     * 
     * @param ContactRequest $request
     * 
     * @return warning/error/success true/false
     */
    public function store(ContactRequest $request)
    {
        DB::beginTransaction();
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }
            $result = $this->contactInterface->storeContacts($request->validated());
            return $this->success('Contacts added', 200, $result);
            DB::commit();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
            DB::rollBack();
        }
    }

    /**
     * Update the Specific Contact
     * 
     * @param ContactRequest $request
     * @param $id
     * 
     * @return warning/error/success true/false
     */
    public function update(ContactRequest $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }
            $result = $this->contactInterface->updateContacts($request->validated(), $id);
            return $this->success('Contacts updated', 200, $result);
            DB::commit();
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
            DB::rollBack();
        }
    }

    /**
     * Remove the Specific contacts
     * 
     * @param $id
     * @return error/success true/false
     */
    public function delete($id)
    {
        DB::beginTransaction();
        try {
            $result =  $this->contactInterface->deleteContacts($id);
            return $this->success('Contacts deleted', 200, $result);
            DB::commit();
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
            DB::rollBack();
        }
    }
}
