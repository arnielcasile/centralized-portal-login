<?php

namespace App\Http\Controllers;


use App\Http\Requests\TokenRequest;
use App\Interfaces\TokenInterface;
use App\Traits\ResponseAPI;

class TokenController extends Controller
{
    use ResponseAPI;
    protected $TokenInterface;

    public function __construct(TokenInterface $TokenInterface)
    {
        $this->TokenInterface = $TokenInterface;
    }

    public function load()
    {
        try {
            $result = $this->TokenInterface->loadAllToken();
            return $this->success('Token Loaded', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
    public function get($id)
    {
        try {
            $result = $this->TokenInterface->getSpecificToken(['auth_token' => $id]);
            return $this->success('Token data loaded', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getLine(), 500);
        }
    }

    public function store(TokenRequest $request)
    {
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }
            $result = $this->TokenInterface->storeToken($request->validated());
            return $this->success('Token added', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update(TokenRequest $request, $id)
    {
        try {
            if ($request->validator->fails()) {
                return $this->warning('Invalid Inputs', 400, $request->validator->errors());
            }

            $result = $this->TokenInterface->updateToken($id, $request->validated());
            return $this->success('Token updated', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function delete($id)
    {
        try {
            $result = $this->TokenInterface->deleteToken($id);
            return $this->success('Token deleted', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(),500);
        }
    }
}
