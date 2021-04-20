<?php

namespace App\Repositories;

use App\Interfaces\AccessTokenInterface;
use App\Models\AccessToken;
use Illuminate\Support\Str;

class AccessTokenRepository implements AccessTokenInterface
{
    /**
     * Load all Access Token from Storage
     */
    public function loadAllAccessToken()
    {
        return AccessToken::all();
    }

    /**
     * Get the specific Token from Storage
     * The paramater used was coming from Interface
     * 
     * @param $id
     * @return object data
     */
    public function getSpecificAccessToken($id)
    {
        return AccessToken::find($id);
    }

    /**
     * Store the new Access in storage
     * The paramater used was coming from Interface
     * 
     * @param $request
     * @return true/false
     */
    public function storeAccessToken($request)
    {
        $Token = new AccessToken;
        $Token->access_token                =  Str::random(64);
        $Token->system_id                   = $request['system_id'];
        return $Token->save();
    }

    /**
     * Update the Access Token from Storage
     * The paramater used was coming from Interface
     * 
     * @param $id
     * @param $request
     * @return true/false
     */
    public function updateAccessToken($id, $request)
    {
        $Token = AccessToken::find($id);
        $Token->access_token                =  Str::random(64);
        $Token->system_id                   =  $request['system_id'];
        return $Token->save();
    }

    /**
     * Remove the Access Token in Storage
     * The paramater used was coming from Interface
     * 
     * @param $id
     * @return true/false
     */
    public function deleteAccessToken($id)
    {
        $result = false;
        
        $systems = AccessToken::destroy($id);

        if ($systems) {
            $result = true;
        }
        return $result;
    }
}
