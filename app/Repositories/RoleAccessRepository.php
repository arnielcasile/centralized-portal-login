<?php

namespace App\Repositories;

use App\Interfaces\RoleAccessInterface;
use App\Models\RoleAccess;

class RoleAccessRepository implements RoleAccessInterface
{
    /**
     * Load all Role Access from storage
     * 
     * @return object data
     */
    public function loadAllRoleAccess()
    {
        return RoleAccess::all();
    }

    /**
     * Get the specific Role Access from storage
     * The parameter used is coming from Interface
     *  
     * @param $id
     * @return object data
     */
    public function getSpecificRoleAccess($id)
    {
        return RoleAccess::find($id);
    }

    /**
     * Store the created Role Access in storage
     * The parameter used is coming from controller
     * 
     * @param $request
     * @return true/false
     */
    public function storeRoleAccess($request)
    {
        $RoleAccess = RoleAccess::updateOrCreate([
            'system_access_id'       => $request['system_access_id'],
            'role_id'                => $request['role_id'],
        ],[
            'system_access_id'       => $request['system_access_id'],
            'role_id'                => $request['role_id'],
        ]);

        return $RoleAccess;
    }

    /**
     * Update the specific Role Access from storage
     * The parameter used is coming from controller
     * 
     * @param $request
     * @param $id
     * @return true/false
     */
    public function updateRoleAccess($request, $id)
    {
        $RoleAccess = RoleAccess::find($id);
        $RoleAccess->system_access_id   = $request['system_access_id'];
        $RoleAccess->role_id            = $request['role_id'];
        return $RoleAccess->save();
    }

    /**
     * Remove the specific Role Access from storage
     * The parameter used is coming from controller
     * 
     * @param $id
     * @return true/false
     */
    public function deleteRoleAccess($id)
    {
        $result = false;
        
        $systems = RoleAccess::destroy($id);

        if ($systems) {
            $result = true;
        }
        return $result;
    }
}