<?php

namespace App\Interfaces;

/**
 * Interface serve as access method for controller and Repository
 * Important: Make Sure that the number method in controller is the same from interface
 */
interface ContactInterface
{
    /**
     * Load all Contacts
     */
    public function loadAllContacts();

    /**
     * Get the specific contacts
     * The paramater used was coming from Controller
     * 
     * @param $id
     */
    public function getSpecificContacts($id);
    
    /**
     * Store the new contacts
     * The paramater used was coming from Controller
     * 
     * @param $request
     */
    public function storeContacts($request);

    /**
     * Update the specific contacts
     * The paramater used was coming from Controller
     * 
     * @param $request
     * @param $id
     */
    public function updateContacts($request, $id);

    /**
     * Remove the specific contacts
     * The paramater used was coming from Controller
     * 
     * @param $id
     */
    public function deleteContacts($id);
}
