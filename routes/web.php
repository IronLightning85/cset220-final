<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;

use App\Http\Controllers\HomeController;

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


// Home route   

Route::get('/home', function () {
    $level = session('level', null); // Check if the user has a level in the session
    return view('home', compact('level')); // Pass the level to the view
})->name('home');


// Common routes for all roles placeholders

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/roster', [HomeController::class, 'showRoster'])->name('roster');
