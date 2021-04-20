<?php

namespace App\Interfaces;
interface UserInterface
{
    public function load_sections();

    public function load_hris_masterlist();

    public function get_user_from_hris($emp_id);

    public function get_user_from_local($emp_id);

    public function get_registered_user();

    public function get_registered_users_per_system($system_id);

    public function authenticate($credentials);

    public function registeredUser($empid);

    public function updateUserEmail($request, $empid);

    public function deleteUser($empid);

    public function logOutUser($empid);

    public function updateUserPassword($request, $empid);

    public function resetPassword($empid, $data);

    public function getSpecificUser($empid);
}
