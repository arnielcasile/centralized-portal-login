<?php

namespace App\Interfaces;

/**
 * Interface serve as access method for controller and Repository
 */
interface AccessTokenInterface
{
    /**
     * load all Access Token
     */
    public function loadAllAccessToken();

    /**
     * get the specific Access Token
     * The paramater used was coming from Controller
     * 
     * @param $id
     */
    public function getSpecificAccessToken($id);

    /**
     * Store the new Access Token
     * The paramater used was coming from Controller
     * 
     * @param $request
     */
    public function storeAccessToken($request);

    /**
     * Update the Access Token
     * The paramater used was coming from Controller
     * 
     * @param $id
     * @param $request
     */
    public function updateAccessToken($id, $request);

    /**
     * Remove Access Token
     * The paramater used was coming from Controller
     * 
     * @param $id
     */
    public function deleteAccessToken($id);

}
