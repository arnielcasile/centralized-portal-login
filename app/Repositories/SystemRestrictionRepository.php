<?php

namespace App\Repositories;

use App\Interfaces\SystemRestrictionInterface;
use App\Models\SystemRestriction;

class SystemRestrictionRepository implements SystemRestrictionInterface
{
    public function load()
    {
        return SystemRestriction::all();
    }

    public function get($id)
    {
        return SystemRestriction::find($id);
    }

    public function store($request)
    {
        $data = new SystemRestriction();
        $data->system_access_id    = $request['system_access_id'];
        $data->role_id             = $request['role_id'];
        return $data->save();
    }

    public function update($id, $request)
    {
        $data = SystemRestriction::find($id);
        $data->system_access_id    = $request['system_access_id'];
        $data->role_id             = $request['role_id'];
        return $data->save();
    }

    public function delete($id)
    {
        $result = false;

        $data = SystemRestriction::destroy($id);

        if ($data) {
            $result = true;
        }
        
        return $result;
    }
}
