<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);



Route::get('/register', [Controller::class, 'showRegistrationForm'])->name('register.form');

Route::post('/register', [Controller::class, 'store'])->name('register');



Route::get('/unapproved-users', [UserController::class, 'showUnapprovedUsers'])->name('unapproved-users');

Route::post('/approve-user/{id}', [UserController::class, 'approveUser'])->name('approve-user');

Route::post('/deny-user/{id}', [UserController::class, 'denyUser'])->name('deny-user');

Route::get('/approved-users', [UserController::class, 'showApprovedUsers'])->name('approved-users');

Route::post('/update-role/{id}', [UserController::class, 'updateRole'])->name('update-role');

Route::get('/available-roles', [UserController::class, 'getAvailableRoles']);