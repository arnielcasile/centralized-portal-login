<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\Models\AccessToken;
use App\Models\User;
use App\Models\HrisSections;
use App\Models\HrisMasterlist;
use App\Models\PasswordHistory;
use App\Models\RoleAccess;
use App\Models\Systems;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    public function load_sections()
    {
        $key = "hris_section";
        if ($HrisSection = Redis::get($key)) {
            return json_decode($HrisSection);
        }
        $HrisSection = HrisSections::all('id', 'section', 'section_code');
        Redis::set($key, $HrisSection);

        return $HrisSection;
    }

    public function load_hris_masterlist()
    {
        $key = "hrismasterlist";
        if ($Hris = Redis::get($key)) {
            return json_decode($Hris);
        }
        $Hris = HrisMasterlist::all();
        Redis::set($key, $Hris);

        return $Hris;
    }

    public function get_user_from_hris($emp_id)
    {
        $key = "hrismasterlist_{$emp_id}";
        if ($HrisMasterlist = Redis::get($key)) {
            return json_decode($HrisMasterlist);
        }
        $HrisMasterlist = HrisMasterlist::where('emp_pms_id', $emp_id)->first();
        Redis::set($key, $HrisMasterlist);

        return $HrisMasterlist;
    }

    public function get_user_from_local($emp_id)
    {
        $LocalUser =  User::where('emp_id', $emp_id)->first();
        return $LocalUser;
    }

    public function get_registered_user()
    {
        $LocalUser =  User::all();
        return $LocalUser;
    }

    public function get_registered_users_per_system($system_id)
    {
        $SystemUsers = User::where('b.id',$system_id)
                        ->where('a.status',1)
                        ->whereNull('d.deleted_at')
                        ->join('system_accesses as a','users.emp_id','=','a.emp_id')
                        ->join('systems as b','a.system_id','=','b.id')
                        ->join('roles as c','c.system_id','=','b.id')
                        ->join('role_accesses as d', function ($join) {
                            $join->on('a.id', '=', 'd.system_access_id');
                            $join->on('c.id', '=', 'd.role_id');
                        })
                        ->select('d.id as role_id','users.emp_id','role','a.status','a.id','users.email','abbreviation')
                        ->get();
                        
        return $SystemUsers;
    }

    public function updateUserEmail($data, $empid)
    {
        $User = User::where('emp_id', $empid);
        return $User->update($data);
    }

    public function updateUserPassword($data, $empid)
    {
        $User = User::where('emp_id', $empid)
                    ->update($data);
        $passwordHistory = PasswordHistory::create([
            'emp_id' => $empid,
            'password' => $data['password']
        ]);

        return $User;
    }

    public function deleteUser($empid)
    {
        $User = User::where('emp_id', $empid)->delete();
        return $User;
    }

    public function resetPassword($empid, $data)
    {
        $User = User::where('emp_id', $empid)
        ->update($data);

        return $User;
    }

    public function authenticate($credentials)
    {
        $result = [];
        if (Auth::attempt($credentials)) 
        {
            $empid = Auth::user()->emp_id;
            $result['status'] = true;
            $result['user_info'] = Auth::user();
            $systems = $this->getsystem($empid);
            $result['systems_with_access'] = [];
            if(count($systems) > 0)
            {
                $hrissection = $this->load_sections();
                $result['user_token'] = $this->gettokens($empid);
                foreach ($systems as $value) {
                    foreach ($hrissection as $section_value) {
                        if($section_value->id ==  $value->section_owner)
                        {
                            $sectionowner = $section_value->section_code;
                        }
                    }
                    
                    $roles = $this->getRoleAccess($value->system_access_id);
                    $accessToken = $this->getAccessToken($value->system_access_id);
                    $system_with_access[] = [
                        'id'                    => $value->id,
                        'name'                  => $value->name,
                        'abbreviation'          => $value->abbreviation,
                        'reference_code'        => $value->reference_code,
                        'reference_number'      => $value->reference_number,
                        'description'           => $value->description,
                        'url'                   => $value->url,
                        'date_deployed'         => $value->date_deployed,
                        'status'                => $value->status,
                        'section_owner'         => $sectionowner,
                        'section_owner_id'      => $value->section_owner,
                        'system_access_id'      => $value->system_access_id,
                        'roles'                 => $roles,
                        'system_access_token'   => $accessToken
                    ];
                }
                $result['systems_with_access'] = $system_with_access;
            }
        } 
        else 
        {
            $result['status'] = false;
        }
        return $result;
    }

    public function registeredUser($data)
    {
        $user = User::create($data);
        $passwordHistory = PasswordHistory::create($data);

        return $user;
    }

    public function gettokens($emp_id)
    {
        $Token = Token::where('emp_id',$emp_id)->first();

        return $Token;       
    }

    public function getsystem($empid)
    {

        $System = Systems::where('emp_id',$empid)
                        ->join('system_accesses as a','systems.id','=','a.system_id')
                        ->select('systems.id', 'name', 'abbreviation', 'reference_code', 'reference_number', 'description', 
                        'url', 'date_deployed', 'systems.status', 'section_owner','a.id as system_access_id','a.status')
                        ->get();
        return $System;    
    }

    public function getRoleAccess($system_id)
    {
        $RoleAccess = RoleAccess::where('system_access_id',$system_id)
                    ->join('roles as a','a.id','=','role_accesses.role_id')
                    ->get(); 
        return $RoleAccess;
    }

    public function getAccessToken($system_id)
    {
        return AccessToken::where('system_id',$system_id)
                    ->first();
    }

    public function logOutUser($empid)
    {
        $result = false;
        
        $systems = Token::where('emp_id', $empid)
                        ->delete();

        if ($systems) {
            $result = true;
        }
        return $result;
    }
    public function getSpecificUser($empid)
    {
        $result_data = User::where('emp_id',$empid)->first();

        if($result_data != null)
        {
            $Token  = $this->AccessSystemRole($result_data->emp_id);
            $Hris   = $this->get_user_from_hris($result_data->emp_id);

            if($result_data->emp_id === $Hris->emp_pms_id){
                $result = [
                    'id'                => $result_data->id,
                    'emp_id'            => $result_data->emp_id,
                    'emp_last_name'     => $Hris->emp_last_name,
                    'emp_first_name'    => $Hris->emp_first_name,
                    'emp_middle_name'   => $Hris->emp_middle_name,
                    'emp_photo'         => $Hris->emp_photo,
                    'position'          => $Hris->position,
                    'section'           => $Hris->section,
                    'email'             => $result_data->email,
                ];
            }
            $data = [];
            foreach ($Token as $value) {
                $data[$value->abbreviation][] = [
                    'system_id'   => $value->id,
                    'role'        => $value->role
                ];  
            }
            $result["system_access"] = $data;

            return $result;
        }               
        
        return false;
    }

    public function AccessSystemRole($emp_id)
    {
        return Systems::where('emp_id',$emp_id)
                        ->where('a.status',1)
                        ->join('system_accesses as a','systems.id','=','a.system_id')
                        ->join('roles as b','systems.id','=','b.system_id')
                        ->join('role_accesses as d', function ($join) {
                            $join->on('a.id', '=', 'd.system_access_id');
                            $join->on('b.id', '=', 'd.role_id');
                        })
                        ->select('role','abbreviation','systems.id')
                        ->get();
    }
}
