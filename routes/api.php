<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;



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


//Login   Idk if i need this tbh i cant remember
Route::post('/login', [LoginController::class, 'login']);

//Authenticate
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user', [AuthController::class, 'getUser']);


//Roles
Route::get('/roles', [RoleController::class, 'index']); //get all roles
Route::post('/roles', [RoleController::class, 'store']); //insert new role into table

