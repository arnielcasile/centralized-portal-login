<?php

namespace App\Http\Controllers;

use App\Http\Requests\SystemRestrictionRequest;
use Illuminate\Http\Request;
use App\Interfaces\SystemRestrictionInterface;
use App\Traits\ResponseAPI;

class SystemRestrictionController extends Controller
{
    use ResponseAPI;
    protected $systemRestrictionInterface;

    public function __construct(SystemRestrictionInterface $systemRestrictionInterface)
    {
        $this->systemRestrictionInterface = $systemRestrictionInterface;
    }

    public function load()
    {
        try {
            $result = $this->systemRestrictionInterface->load();
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
    public function get($id)
    {
        try {
            $result = $this->systemRestrictionInterface->get($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function store(SystemRestrictionRequest $request)
    {
        try {
            $result = $this->systemRestrictionInterface->store($request->validated());
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(SystemRestrictionRequest $request, $id)
    {
        try {
            $result = $this->systemRestrictionInterface->update($id, $request->validated());
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->systemRestrictionInterface->delete($id);
            return $this->success('Successfully Executed', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(),500);
        }
    }
}
