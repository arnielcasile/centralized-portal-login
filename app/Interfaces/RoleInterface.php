<?php

namespace App\Interfaces;

/**
 * Interface serve as access method for controller and Repository
 * Important: Make Sure that the number method from controller is the same in interface
 */
interface RoleInterface
{
    /**
     * Get all Role from Repository
     * 
     */
    public function load($system_id);

    /**
     * Get the specific Role from Repository
     * The parameter used was coming from Controller 
     * 
     * @param $id
     */
    public function get($id);

    /**
     * Store the created Role from Repository
     * The parameter used was coming from Controller
     * 
     * @param $request
     */
    public function store($request);

    /**
     * Update the specific Role
     * The parameter used was coming from Controller
     * 
     * @param $id
     * @param $request
     */
    public function update($id, $request);

    /**
     * Remove the specific Role 
     * The parameter used was coming from Controller
     * 
     * @param $id
     */
    public function delete($id);
}
