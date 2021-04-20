<?php

namespace App\Repositories;

use App\Interfaces\RoleInterface;
use App\Models\Role;

class RoleRepository implements RoleInterface
{
    /**
     * Load All Roles from storage
     * 
     * @return object data
     */
    public function load($system_id)
    {
        return Role::where('roles.system_id',$system_id)
                    ->whereNull(['roles.deleted_at'])
                    ->join('systems as a','a.id','=','roles.system_id')
                    ->select('roles.id','role','roles.description')
                    ->get();
    }

    /**
     * Get the specific Role from storage
     * The parameter used was coming from Interface
     * 
     * @param $id
     * @return object data
     */
    public function get($id)
    {
        return Role::find($id);
    }

    /**
     * Store the created Role in storage
     * The parameter used was coming from Interface
     * 
     * @param $request
     * @return true/false
     */
    public function store($request)
    {
        $role = new Role;
        $role->system_id     = $request['system_id'];
        $role->role          = $request['role'];
        $role->description   = $request['description'];
        return $role->save();
    }

    /**
     * Update the specific the Role from storage
     * The parameter used was coming from Interface
     *
     * @param $id
     * @return false/true
     */
    public function update($id, $request)
    {
        $role = Role::find($id);
        $role->system_id     = $request['system_id'];
        $role->role          = $request['role'];
        $role->description   = $request['description'];
        return $role->save();
    }

    /**
     * Remove the specific Role from storage
     * The parameter used was comign from Interface
     * 
     * @param $id
     * @return true/false
     */
    public function delete($id)
    {
        $result = false;

        $role = Role::destroy($id);

        if ($role) {
            $result = true;
        }
        
        return $result;
    }
}
