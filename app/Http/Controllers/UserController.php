<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HrisMasterlist;
use App\Interfaces\UserInterface;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Interfaces\TokenInterface;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use ResponseAPI, ThrottlesLogins;
    protected $userInterface;
    protected $tokenInterface;
    protected $maxAttempts = 5; // Default is 5
    protected $decayMinutes = 1; // Default is 1


    public function __construct(UserInterface $userInterface, TokenInterface $tokenInterface)
    {
        $this->userInterface = $userInterface;
        $this->tokenInterface = $tokenInterface;
    }

    /**
     * Display all sections
     */
    public function load_sections()
    {
        try {
            $result = $this->userInterface->load_sections();
            return $this->success('Sections Loaded', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display HRIS masterlist
     */
    public function load_hris_masterlist()
    {
        try {
            $result = $this->userInterface->load_hris_masterlist();
            return $this->success('HRIS Data Loaded', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display specific user from hris
     */
    public function get_user_from_hris($emp_id)
    {
        try {
            $result = $this->userInterface->get_user_from_hris($emp_id);
            return $this->success('User Data Retrieved', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display specific user from system local data
     */
    public function get_user_from_local($emp_id)
    {
        try {
            $result =  $this->userInterface->get_user_from_local($emp_id);
            return $this->success('User Data Retrieved', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display specific user from system local data
     */
    public function get_registered_user()
    {
        try {
            $data =  $this->userInterface->get_registered_user();
            $result = $this->combineManpowerRegisteredUsers($data);
            return $this->success('User Data Retrieved', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function registered_user()
    {
        try {
            $data =  $this->userInterface->get_registered_user();
            $result = $this->combineManpowerRegisteredUsers($data);
            return $result;
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function get_system_role_access($emp_id)
    {
        try {
            $result = $this->userInterface->getSpecificUser($emp_id);
            return $this->success('User Data Retrieved', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }


    public function get_registered_users_per_system($system_id)
    {
        try {
            $data =  $this->userInterface->get_registered_users_per_system($system_id);
            if(count($data) == 0)
            {
                $result = [];
            }
            else
            {
                $result = $this->combineManpowerRegisteredUsers($data);
            }
            return $this->success('User Data Retrieved', 200, $result);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function get_unregistered_user_per_system($system_id)
    {
        try 
        {
            $registered_data  = $this->registered_user();
            $users_per_system =  $this->userInterface->get_registered_users_per_system($system_id);


            $data_users = [];
            foreach ($registered_data as $result_users_value) {
                array_push($data_users, $result_users_value['employee_number']);
            }


            $data_system = [];
            foreach ($users_per_system as $result_system_value) {
                array_push($data_system, $result_system_value->emp_id);
            }

            $result_data = array_diff($data_users, $data_system);

            $array_result = [];
            foreach ($result_data as $key => $value) {
                $data_result = [
                    "emp_id"            => $registered_data[$key]['employee_number'],
                    "emp_first_name"    => $registered_data[$key]['last_name'],
                    "emp_last_name"     => $registered_data[$key]['first_name'],
                    "emp_middle_name"   => $registered_data[$key]['middle_name'],
                    "emp_photo"         => $registered_data[$key]['photo'],
                    "position"          => $registered_data[$key]['position'],
                    "section"           => $registered_data[$key]['section']

                ];

                array_push($array_result, $data_result);
            }

            return $this->success("All Users Loaded", 200, $array_result);
        } 
        catch (\Throwable $th) 
        {
            return $this->error($th->getLine(), 500);
        } 
    }

    public function authenticate($credentials)
    {
        try {
            return  $this->userInterface->authenticate($credentials);
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update_email(Request $request, $empid)
    {
        
        $validator = Validator::make(Request()->all(), [
            'email' => 'required',
        ]);

        if ($validator->fails()) {
            return  $this->warning('Invalid inputs', 400, $validator->errors());
        }
        else
        {
            $data = [
                'email' => $request->email
            ];
            try {
                    $result = $this->userInterface->updateUserEmail($data, $empid);
                    return $this->success("Email updated", 200, $result);
            } catch (\Throwable $e) {
                    return $this->error($e->getMessage(), 500);
            }
        }   
    }

    public function delete_user($empid)
    {
        try {
            $result = $this->userInterface->deleteUser($empid);
            return $this->success("User Remove", 200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function reset_password($empid)
    {
        $password = [
            'password' => Hash::make('Fujitsu@1234')
        ];
        try {
            $result = $this->userInterface->resetPassword($empid,$password);
            return $this->success("Password Reset", 200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function update_password($empid, Request $request)
    {

        if(Auth::attempt(['emp_id' => $empid, 'password' => $request->current_password ]) == false)
        {
            return [
                "code"      => 400,
                "status"    => "warning",
                "data"      => "Invalid Current Password!"
            ];
        }

        //Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.
        $validator = Validator::make(request()->all(), [
            'password'      => 'required|string|min:8|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
        ]);

        if ($validator->fails()) {
            return  $this->warning('Invalid inputs', 400, $validator->errors());
        }
        else
        {
            $data = [
                'password' => Hash::make($request->password)
            ];
            try {
                
                $result = $this->userInterface->updateUserPassword($data, $empid);
                return $this->success("Change Password Successfully", 200, $result);
            } catch (\Throwable $e) {
                    return $this->error($e->getMessage(), 500);
            }
        }
    }

    public function registration(Request $request)
    {

        $validator = Validator::make(Request()->all(), [
            'emp_id'    => 'required',
        ]);

        if ($validator->fails()) {
            return  $this->warning('Invalid inputs', 400, $validator->errors());
        } 
        else 
        {
            try 
            {
                $emp_id = $request->emp_id;
                $password = Hash::make('Fujitsu@1234');

                $local_data = $this->userInterface->get_user_from_local($emp_id);

                $result = [];
                if (empty($local_data)) 
                {
                    $hris_data = $this->userInterface->get_user_from_hris($emp_id);
                    if (empty($hris_data)) {
                        $result['status'] = 1;
                        $result['message'] = 'Employee Not Found';
                    } 
                    else 
                    {
                        $data = [
                            'emp_id'    => $emp_id,
                            'password'  => $password
                        ];
                        try {
                            $result = $this->userInterface->registeredUser($data);
                            return $this->success("Registered Successfully",200, true);
                        } catch (\Exception $e) {
                            return $this->error($e->getMessage(), 500);
                        }
                    }
                }
                else
                {
                    return $this->error("Already Registered",500);
                } 
            }
            catch (\Exception $e) 
            {
                return $this->error($e->getMessage(), 500);
            } 
        }  
    }


    /**
     * 1 = User dont exist in portal database
     * 2 = User dont exist in HRIS database
     * 3 = User successfully logged in
     * 4 = USer password incorrect;
     */
    public function login(Request $request)
    {
        $validator = Validator::make(Request()->all(), [
            'emp_id'    => 'required',
            'password'  => 'required',
        ]);

        if ($validator->fails()) {
            return  $this->warning('Invalid inputs', 400, $validator->errors());
        } 
        else 
        {
            try 
            {
                
                $auth = $this->authenticate(Request()->only('emp_id', 'password'));

                // return $request;
                // if ($this->hasTooManyLoginAttempts($request)) {
                //     $this->fireLockoutEvent($request);
                //     return $this->sendLockoutResponse($request);
                // }

                if ($auth['status'] == true) 
                {
                    $result['status'] = 3;
                    $result['message'] = "User Authenticated";
                    $token_data = $this->store($auth['user_info']->emp_id);
                    $hris_data = $this->userInterface->get_user_from_hris($auth['user_info']->emp_id);
                    if(!empty($auth['systems_with_access']))
                    {
                        $result['data'] = $this->combinedataManpower($auth['user_info'], $hris_data,$token_data,$auth['systems_with_access']);  
                    }
                    else
                    {
                        $result['user_token'] = $token_data;
                        $result['data'] = $hris_data;
                    }

                    // $this->clearLoginAttempts($request);

                } 
                else if ($auth['status'] == false) 
                {
                    $result['status'] = 4;
                    $result['message'] = 'Invalid Password';

                    // $this->incrementLoginAttempts($request);
                }
                return $this->success('User Authenticated', 200, $result);
            }
            catch (\Exception $e) 
            {
                return $this->error($e->getMessage(), 500);
            } 
        }  
    }

    public function combinedataManpower($portaldata, $hrisdata, $usertoken, $systems)
    {
        $result = [
            'emp_id'             => $portaldata->emp_id,
            'last_name'          => $hrisdata->emp_last_name,
            'first_name'         => $hrisdata->emp_first_name,
            'middle_name'        => $hrisdata->emp_middle_name,
            'position'           => $hrisdata->position,
            'section_code'       => $hrisdata->section_code,
            'photo'              => $hrisdata->emp_photo,
            'auth_token'         => $usertoken,
            'systems'            => $systems
        ];
        return $result;
    }

    public function store($data)
    {
        try {
            $result = $this->tokenInterface->storeToken(['emp_id' => $data]);
            return $result;
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function combineManpowerRegisteredUsers($data)
    {
        $hris_data = $this->userInterface->load_hris_masterlist();
       
        foreach ($data as $key => $value) {
            foreach ($hris_data as $hrisdata) {
                if($value->emp_id == $hrisdata->emp_pms_id)
                {
                    $result[] = [
                        'system_access_id'  => $value->id,
                        'role_access_id'    => $value->role_id,
                        'employee_number'   => $value->emp_id,
                        'last_name'         => $hrisdata->emp_last_name,
                        'first_name'        => $hrisdata->emp_first_name,
                        'middle_name'       => $hrisdata->emp_middle_name,
                        'email'             => $value->email,
                        'photo'             => $hrisdata->emp_photo,
                        'position'          => $hrisdata->position,
                        'section'           => $hrisdata->section,
                        'abbreviation'      => $value->abbreviation,
                        'section_code'      => $hrisdata->section_code,
                        'role'              => $value->role,
                        'status'            => $value->status,

                    ];
                }
            }
        }

        return $result;
    }

    public function logout($emp_id)
    {
        try {
            $result = $this->userInterface->logOutUser($emp_id);
            return $this->success("Success LogOut", 200, $result);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
