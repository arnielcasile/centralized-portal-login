<?php

namespace App\Repositories;

use App\Interfaces\TokenInterface;
use App\Models\Token;
use Illuminate\Support\Str;
use App\Models\Systems;
use App\Models\HrisMasterlist;
// use Illuminate\Support\Facades\Redis;

class TokenRepository implements TokenInterface
{
    public function loadAllToken()
    {
        return Token::all();
    }

    public function getSpecificToken($where)
    {
        
        $result_data = Token::where($where)
                        ->join('users as a','tokens.emp_id','=','a.emp_id')
                        ->first();

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
                    'token'             => $result_data->auth_token
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

    public function storeToken($request)
    {
        $Token = new Token;
        $Token->emp_id                   = $request['emp_id'];
        $Token->auth_token               =  Str::random(64);
        $Token->save();
        $LastInsertId = [
            'auth_token' => $Token->auth_token,
            'created_at' => $Token->created_at,
            'updated_at' => $Token->updated_at
        ];
        return $LastInsertId;
    }

    public function updateToken($id, $request)
    {
        $Token = Token::find($id);
        $Token->emp_id                   = $request['emp_id'];
        $Token->auth_token               =  Str::random(64);
        return $Token->save();
    }

    public function deleteToken($id)
    {
        $result = false;
        
        $systems = Token::destroy($id);

        if ($systems) {
            $result = true;
        }
        return $result;
    }

    public function AccessSystemRole($emp_id)
    {
        return Systems::where('emp_id',$emp_id)
                        ->where('a.status',1)
                        ->whereNull('d.deleted_at')
                        ->join('system_accesses as a','systems.id','=','a.system_id')
                        ->join('roles as b','systems.id','=','b.system_id')
                        ->join('role_accesses as d', function ($join) {
                            $join->on('a.id', '=', 'd.system_access_id');
                            $join->on('b.id', '=', 'd.role_id');
                        })
                        ->select('role','abbreviation','systems.id')
                        ->get();
    }

    public function get_user_from_hris($emp_id)
    {
        // $key = "hrismasterlist_{$emp_id}";
        // if ($HrisMasterlist = Redis::get($key)) {
        //     return json_decode($HrisMasterlist);
        // }
        $HrisMasterlist = HrisMasterlist::where('emp_pms_id', $emp_id)->first();
        // Redis::set($key, $HrisMasterlist);

        return $HrisMasterlist;
    }
}
