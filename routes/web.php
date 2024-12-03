<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;

use App\Http\Controllers\HomeController;

use App\Http\Controllers\RoleController;

use App\Http\Controllers\PatientController;

use App\Http\Controllers\EmployeeController;

use App\Http\Controllers\SupervisorController;

use App\Http\Controllers\FamilymemberController;

use App\Http\Controllers\RosterController;

use App\Http\Controllers\CaregiverActivityController;

// I know you guys will find this, so let me clarify: the words are spelled like this
// "Doctor"
// "Independent"
// "Shady Shoals"
// Not:
// "Docter"
// "Independant"
// "Shady Shoal's"
// This bothers me more than you'd think

Route::get('/', function () {
    $level = session('level', null); // Check if the user has a level in the session
    return view('welcome', compact('level'));
});


//Login Route
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

Route::post('/login', [AuthController::class, 'login']);


//Register route
Route::get('/register', [Controller::class, 'showRegistrationForm'])->name('register.form');

Route::post('/register', [Controller::class, 'store'])->name('register');


Route::get('/unapproved-users', [UserController::class, 'showUnapprovedUsers'])->name('unapproved-users');

Route::post('/approve-user/{id}', [UserController::class, 'approveUser'])->name('approve-user');

Route::post('/deny-user/{id}', [UserController::class, 'denyUser'])->name('deny-user');

//Patient Page
Route::get('/patient', [PatientController::class, 'index']);

Route::post('/patient', [PatientController::class, 'store'])->name('patient');

//Employee Page
Route::get('/employee', [EmployeeController::class, 'index']);

Route::post('/employee', [EmployeeController::class, 'store'])->name('employee');


//Roles
Route::get('/role', [RoleController::class, 'index']);

Route::post('/role', [RoleController::class, 'store'])->name('role');
$name = session('first_name', null); 


// Home route   

Route::get('/home', function () {
    $level = session('level', null); // Check if the user has a level in the session
    $first_name = session('first_name'); // Check if the user has a name in the session
    return view('home', compact('first_name'), compact('level')); // Pass the level and name to the view
})->name('home');


// Common routes for all roles placeholders

Route::get('/payment', [UserController::class, 'showPaymentPage'])->name('payment');

Route::post('/make-payment', [UserController::class, 'processPayment'])->name('process-payment');

Route::get('/payments', [UserController::class, 'showPaymentsPage'])->name('payments');

Route::post('/payments/update', [UserController::class, 'updatePayments'])->name('payments-update');

Route::post('/update-role/{user_id}', [UserController::class, 'updateRole'])->name('update-role');

Route::get('/approved-users', [UserController::class, 'showApprovedUsers'])->name('approved-users');

Route::get('/unapproved-users', [UserController::class, 'showUnapprovedUsers'])->name('unapproved-users');

Route::get('/approved-patients', [UserController::class, 'showApprovedPatients'])->name('approved-patients');

Route::post('/update-admission-date/{patient_id}', [UserController::class, 'updateAdmissionDate'])->name('update-admission-date');

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//Roster

Route::get('/roster', [RosterController::class, 'index']); //Get today's roster

Route::post('/roster', [RosterController::class, 'specificDateRoster'])->name('roster'); //Get today's roster

Route::get('/create-roster', [RosterController::class, 'create_roster_index']);

Route::post('/create-roster', [RosterController::class, 'store'])->name('create_roster');

Route::post('/apply-charges', [UserController::class, 'applyDailyCharges'])->name('apply-charges');

//Caregiver Home

Route::get('/caregiver-home', [RosterController::class, 'index']);

Route::post('/caregiver-home', [RosterController::class, 'store'])->name('caregiver-home');

Route::post('/admin/apply-charges', [UserController::class, 'applyDailyCharges'])->name('admin.apply-charges');

Route::get('/daily-activities', [CaregiverActivityController::class, 'showAllPatientsWithActivities'])->name('showDailyActivities');

Route::post('/daily-activities/update', [CaregiverActivityController::class, 'updateDailyActivities'])->name('updateDailyActivities');