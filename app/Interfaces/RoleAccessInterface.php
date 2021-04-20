<?php

namespace App\Interfaces;

/**
 * Interface serve as access method for controller and Repository
 * Important: Make Sure that the number method from controller is the same in interface
 */
interface RoleAccessInterface
{
    /**
     * Load All the Role Access from Repository
     */
    public function loadAllRoleAccess();

    /**
     * Get the Specific Role Access from Repository
     * The parameter used is coming from controller
     * 
     * @param $id
     */
    public function getSpecificRoleAccess($id);

    /**
     * Store the created Role Access into Ropository
     * The parameter used is coming from controller
     * 
     * @param $request
     */
    public function storeRoleAccess($request);

    /**
     * Update the specific Role Access into Repository
     * The parameter used is coming from controller
     * 
     * @param $request
     * @param $id
     */
    public function updateRoleAccess($request, $id);

    /**
     * Remove the specific Role Access into Repository
     * The parameter used is coming from controller
     * 
     * @param $id
     */
    public function deleteRoleAccess($id);
}