<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SpaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SystemsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\ContactsController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\RoleAccessController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\SystemAccessController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


/*USERS*/
Route::get('/user/load-sections', [UserController::class, 'load_sections']);
Route::get('/user/load-hris-masterlist', [UserController::class, 'load_hris_masterlist']);
Route::get('/user/get-user-from-hris/{id}', [UserController::class, 'get_user_from_hris']);
Route::get('/user/get-user-from-local/{id}', [UserController::class, 'get_user_from_local']);
Route::get('/user/load-all-registered-users', [UserController::class, 'get_registered_user']);
Route::get('/user/load-all-registered-users-per-system/{system_id}', [UserController::class, 'get_registered_users_per_system']);
Route::get('/user/load-all-unregistered-users-per-system/{system_id}', [UserController::class, 'get_unregistered_user_per_system']);
Route::post('/user/login', [UserController::class, 'login'])->middleware("throttle:10,2");
Route::post('/user/register', [UserController::class, 'registration']);
Route::patch('/user/update-email/{empid}', [UserController::class, 'update_email']);
Route::patch('/user/update-password/{empid}', [UserController::class, 'update_password']);
Route::patch('/user/reset-password/{empid}', [UserController::class, 'reset_password']);
Route::delete('/user/delete/{empid}', [UserController::class, 'delete_user']);
Route::delete('/user/logout/{empid}', [UserController::class, 'logout']);
Route::get('/user/system-role-access/{emp_id}', [UserController::class, 'get_system_role_access']);

/*SYSTEMS*/
Route::get('/systems/load', [SystemsController::class, 'load']);
Route::get('/systems/get/{id}', [SystemsController::class, 'get']);
Route::post('/systems/store', [SystemsController::class, 'store']);
Route::patch('/systems/update/{id}', [SystemsController::class, 'update']);
Route::delete('/systems/delete/{id}', [SystemsController::class, 'delete']);

Route::get('/system-access/load', [SystemAccessController::class, 'load']);
Route::get('/system-access/get/{id}', [SystemAccessController::class, 'get']);
Route::post('/system-access/store', [SystemAccessController::class, 'store']);
Route::patch('/system-access/update/{id}', [SystemAccessController::class, 'update']);
Route::delete('/system-access/delete/{id}', [SystemAccessController::class, 'delete']);

Route::get('/role/load/{system_id}', [RoleController::class, 'load']);
Route::get('/role/get/{id}', [RoleController::class, 'get']);
Route::post('/role/store', [RoleController::class, 'store']);
Route::patch('/role/update/{id}', [RoleController::class, 'update']);
Route::delete('/role/delete/{id}', [RoleController::class, 'delete']);

Route::get('/role-access/load', [RoleAccessController::class, 'load']);
Route::get('/role-access/get/{id}', [RoleAccessController::class, 'get']);
Route::post('/role-access/store', [RoleAccessController::class, 'store']);
Route::patch('/role-access/update/{id}', [RoleAccessController::class, 'update']);
Route::delete('/role-access/delete/{id}', [RoleAccessController::class, 'delete']);

/**TOKEN */
Route::get('/access-token/load', [AccessTokenController::class, 'load']);
Route::get('/access-token/get/{token}', [AccessTokenController::class, 'get']);
Route::post('/access-token/store', [AccessTokenController::class, 'store']);
Route::patch('/access-token/update/{id}', [AccessTokenController::class, 'update']);
Route::delete('/access-token/delete/{id}', [AccessTokenController::class, 'delete']);

Route::get('/token/load', [TokenController::class, 'load']);
Route::get('/token/get/{id}', [TokenController::class, 'get']);
Route::post('/token/store', [TokenController::class, 'store']);
Route::patch('/token/update/{id}', [TokenController::class, 'update']);
Route::delete('/token/delete/{id}', [TokenController::class, 'delete']);


/**INFORMATION */
Route::get('/contacts/load', [ContactsController::class, 'load']);
Route::get('/contacts/get/{id}', [ContactsController::class, 'get']);
Route::post('/contacts/store', [ContactsController::class, 'store']);
Route::patch('/contacts/update/{id}', [ContactsController::class, 'update']);
Route::delete('/contacts/delete/{id}', [ContactsController::class, 'delete']);

Route::get('/images/load', [ImagesController::class, 'load']);
Route::get('/images/get/{id}', [ImagesController::class, 'get']);
Route::post('/images/store', [ImagesController::class, 'store']);
Route::patch('/images/update/{id}', [ImagesController::class, 'update']);
Route::delete('/images/delete/{id}', [ImagesController::class, 'delete']);