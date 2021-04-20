<?php

namespace App\Interfaces;


interface TokenInterface
{
    public function loadAllToken();

    public function getSpecificToken($id);

    public function storeToken($request);

    public function updateToken($id, $request);

    public function deleteToken($id);
}
