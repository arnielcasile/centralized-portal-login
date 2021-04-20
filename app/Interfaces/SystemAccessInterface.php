<?php

namespace App\Interfaces;

/**
 * Interface serve as access method for controller and Repository
 * Important: Make Sure that the number method from controller is the same in interface
 */
interface SystemAccessInterface
{
    /**
     * Get all System Access from Repository 
     */
    public function loadAllSystemAccess();

    /**
     * Get the specific System Access from Repository
     * The parameter used is coming from Controller
     * 
     * @param $id
     */
    public function getSpecificSystemAccess($id);

    /**
     * Store the created System Access
     * The parameter used is coming from Controller
     * 
     * @param $request
     */
    public function storeSystemAccess($request);

    /**
     * Update the specific System Access
     * The parameter used is coming from Controller
     * 
     * @param $id
     * @param $request
     */
    public function updateSystemAccess($id, $request);

    /**
     * Remove the specific System Access
     * The parameter used is coming from Controller
     * 
     * @param $id
     */
    public function deleteSystemAccess($id);

    /**
     * Remove the specific System Access
     * The parameter used is coming from Controller
     * 
     * @param $id
     */
    public function checkSystemAccess($empid, $systemid);

    /**
     * Remove the specific System Access
     * The parameter used is coming from Controller
     * 
     * @param $id
     */
    public function restoreSystemAccess($id);
}
