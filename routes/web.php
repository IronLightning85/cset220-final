<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\RoleController;

use App\Http\Controllers\PatientController;

use App\Http\Controllers\SupervisorController;

use App\Http\Controllers\FamilymemberController;

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

//Login Route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);


//Register route
Route::get('/register', [Controller::class, 'showRegistrationForm'])->name('register.form');
Route::post('/register', [Controller::class, 'store'])->name('register');



Route::get('/unapproved-users', [UserController::class, 'showUnapprovedUsers'])->name('unapproved-users');

//Patient Page
Route::get('/patient', [PatientController::class, 'index']);
Route::post('/patient', [PatientController::class, 'store'])->name('patient');


//Roles
Route::get('/role', [RoleController::class, 'index']);
Route::post('/role', [RoleController::class, 'store'])->name('role');



// Home route   

Route::get('/home', [HomeController::class, 'showHome'])->name('home');

// Common routes for all roles placeholders

Route::get('/available-roles', [UserController::class, 'getAvailableRoles'])->name('available-roles');

Route::get('/approved-patients', [UserController::class, 'showApprovedPatients'])->name('approved-patients');

Route::post('/update-admission-date/{patient_id}', [UserController::class, 'updateAdmissionDate'])->name('update-admission-date');

Route::get('/logout', [HomeController::class, 'logout'])->name('logout');

Route::get('/roster', [HomeController::class, 'showRoster'])->name('roster');