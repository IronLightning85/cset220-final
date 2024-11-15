<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;
use App\Http\Controllers\Controller;

use App\Http\Controllers\homeController;

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

Route::get('/patient', [PatientController::class, 'index'])->name('patient');



//This ensures the user is logged in to view the routes

Route::middleware(['auth'])->group(function() {

    // Home route
    Route::get('/home', [HomeController::class, 'showHome'])->name('home');

    // Common routes for all roles placeholders
    Route::get('/logout', [HomeController::class, 'logout'])->name('logout');
    Route::get('/roster', [HomeController::class, 'showRoster'])->name('roster');

    // Family-only routes placeholders
    Route::middleware(['role:family'])->group(function () {
        Route::get('/family', [FamilyMemberController::class, 'index'])->name('family.info');
    });

    // Patient-only routes placeholders
    Route::middleware(['role:patient'])->group(function () {
        Route::get('/patientHome', [PatientController::class, 'index'])->name('patient.home');
    });

    // Admin-only routes placeholders for now 
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/appointment', [AdminController::class, 'appointment'])->name('admin.appointment');
        Route::get('/employee', [AdminController::class, 'employeeList'])->name('admin.employee.list');
        Route::get('/patients', [AdminController::class, 'patientsList'])->name('admin.patients.list');
        Route::get('/unapproved-users', [AdminController::class, 'approveUsers'])->name('admin.approve.users');
        Route::get('/new-roster', [AdminController::class, 'newRoster'])->name('admin.new.roster');
        Route::get('/report', [AdminController::class, 'report'])->name('admin.report');
        Route::get('/payment', [AdminController::class, 'payment'])->name('admin.payment');
    });

    // Supervisor-only routes placeholders
    Route::middleware(['role:supervisor'])->group(function () {
        Route::get('/appointment', [SupervisorController::class, 'appointment'])->name('supervisor.appointment');
        Route::get('/employee', [SupervisorController::class, 'employeeList'])->name('supervisor.employee.list');
        Route::get('/patients', [SupervisorController::class, 'patientsList'])->name('supervisor.patients.list');
        Route::get('/unapproved-users', [SupervisorController::class, 'approveUsers'])->name('supervisor.approve.users');
        Route::get('/new-roster', [SupervisorController::class, 'newRoster'])->name('supervisor.new.roster');
        Route::get('/report', [SupervisorController::class, 'report'])->name('supervisor.report');
    });

    //need to be put in rights middleware
    Route::post('/approve-user/{id}', [UserController::class, 'approveUser'])->name('approve-user');

    Route::post('/deny-user/{id}', [UserController::class, 'denyUser'])->name('deny-user');
    
    Route::get('/approved-users', [UserController::class, 'showApprovedUsers'])->name('approved-users');
    
    Route::post('/update-role/{id}', [UserController::class, 'updateRole'])->name('update-role');
    
    Route::get('/available-roles', [UserController::class, 'getAvailableRoles']);

});


