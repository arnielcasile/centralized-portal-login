<?php

namespace  App\Repositories;

use App\Interfaces\ContactInterface;
use App\Models\Contacts;

class ContactRepository implements ContactInterface
{
    /**
     * Load all Contacts from storage
     */
    public function loadAllContacts()
    {
        return Contacts::all();
    }

    /**
     * Get the specific Contacts
     * The paramter used is coming from interface
     * 
     * @param $id
     * @return object w/data
     */
    public function getSpecificContacts($id)
    {
        return Contacts::find($id);
    }

    /**
     * Store the new contacts in storge
     * The paramter used is coming from interface
     * 
     * @param $request
     * @return true/false
     */
    public function storeContacts($request)
    {
        $Contacts = new Contacts;
        $Contacts->emp_id       = $request['emp_id'];
        $Contacts->system_id    = $request['system_id'];
        $Contacts->local_no     = $request['local_no'];
        return $Contacts->save();
    }

    /**
     * Update the specific contact from storage
     * The paramter used is coming from interface
     * 
     * @param $request
     * @param $id
     * @return true/false
     */
    public function updateContacts($request, $id)
    {
        $Contacts = Contacts::find($id);
        $Contacts->emp_id       = $request['emp_id'];
        $Contacts->system_id    = $request['system_id'];
        $Contacts->local_no     = $request['local_no'];
        return $Contacts->save();
    }

    /**
     * Remove the specific contacts from storage
     * The paramter used is coming from interface
     * 
     * @param $id
     * @return true/false
     */
    public function deleteContacts($id)
    {
        $result = false;
        
        $systems = Contacts::destroy($id);

        if ($systems) 
        {
            $result = true;
        }
        return $result;
    }

}
