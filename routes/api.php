<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\RosterController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Users
Route::get('/', [Controller::class, 'index']); // grab all users that have not been approved
Route::post('/', [Controller::class, 'store']); // create account. store data in correct tables

//Authenticate
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUser']);


//Roles
Route::get('/roles', [RoleController::class, 'index']); //get all roles
Route::post('/roles', [RoleController::class, 'store']); //insert new role into table

//Patients
Route::get('/patient', [PatientController::class, 'index']); //get all roles

//Employee
Route::get('/employee', [EmployeeController::class, 'index']); //get all roles
Route::post('/employee', [EmployeeController::class, 'store']); //insert new role into table

//Roster
Route::get('/roster', [RosterController::class, 'index']); //get todays roster
Route::post('/roster', [RosterController::class, 'specificDateRoster']); //get todays roster

Route::get('/create-roster', [RosterController::class, 'create_roster_index']);
Route::post('/create-roster', [RosterController::class, 'store'])->name('create_roster'); 

