<?php

namespace App\Interfaces;

use App\Http\Requests\UserRequest;

interface SystemsInterface
{
    public function load();

    public function get($id);
    
    public function store($request);

    public function update($id, $request);

    public function delete($id);

    public function getSection();
}
