<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactRequest;
use Illuminate\Http\Request;
use App\Interfaces\ContactInterface;
use App\Traits\ResponseAPI;

class ContactController extends Controller
{
    use ResponseAPI;
    protected $contactInterface;

    public function __construct(ContactInterface $contactInterface)
    {
        $this->contactInterface = $contactInterface;
    }

    public function load()
    {
        try {
            $result = $this->contactInterface->load();
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
    public function get($id)
    {
        try {
            $result = $this->contactInterface->get($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(ContactRequest $request)
    {
        try {
            $result = $this->contactInterface->store($request->validated());
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(ContactRequest $request, $id)
    {
        try {
            $result = $this->contactInterface->update($id, $request->validated());
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->contactInterface->delete($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(),500);
        }
    }
}
