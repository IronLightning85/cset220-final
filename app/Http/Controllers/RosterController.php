<?php

namespace App\Http\Controllers;

use App\Models\roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class RosterController extends Controller
{
    //Show Roster Page
    public function index()
    {
        $roster = Roster::where('date', date("Y/m/d"))->first();
        $date = date("Y/m/d");

        if (!$roster) {
            return view('roster', ['roster' => $roster, 'date' => $date])->with('level', session('level'));
        }

        $supervisor = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->supervisor_id)
        ->first();

        $doctor = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->doctor_id)
        ->first();

        $caregiver_1 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_1)
        ->first();

        $caregiver_2 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_2)
        ->first();

        $caregiver_3 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_3)
        ->first();

        $caregiver_4 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_4)
        ->first();


        return view('roster', [
            'roster' => $roster,
            'date' => $date,
            'supervisor' => $supervisor,
            'doctor' => $doctor,
            'caregiver_1' => $caregiver_1,
            'caregiver_2' => $caregiver_2,
            'caregiver_3' => $caregiver_3,
            'caregiver_4' => $caregiver_4,
        ])->with('level', session('level'));    
    }
    
    public function specificDateRoster(Request $request) 
    {
        $roster = Roster::where('date', $request->roster_date)->first();
        $date = $request->roster_date;

        
        if (!$roster) {
            return view('roster', ['roster' => $roster, 'date' => $date])->with('level', session('level'));;
        }

        $supervisor = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->supervisor_id)
        ->first();

        $doctor = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->doctor_id)
        ->first();

        $caregiver_1 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_1)
        ->first();

        $caregiver_2 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_2)
        ->first();

        $caregiver_3 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_3)
        ->first();

        $caregiver_4 = DB::table('employees')
        ->select('users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $roster->caregiver_id_4)
        ->first();


        return view('roster', [
            'roster' => $roster,
            'date' => $date,
            'supervisor' => $supervisor,
            'doctor' => $doctor,
            'caregiver_1' => $caregiver_1,
            'caregiver_2' => $caregiver_2,
            'caregiver_3' => $caregiver_3,
            'caregiver_4' => $caregiver_4,
        ])->with('level', session('level'));
    }

    //Display Creating Roster Page
    public function create_roster_index()
    {
        $date = date("Y/m/d");
        
        $supervisors = DB::table('employees')
        ->select('employees.employee_id', 'users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->join('roles', 'roles.role_id', '=', 'users.role_id')
        ->where('roles.level', '=', 2)
        ->get();

        $doctors = DB::table('employees')
        ->select('employees.employee_id', 'users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->join('roles', 'roles.role_id', '=', 'users.role_id')
        ->where('roles.level', '=', 3)
        ->get();

        $caregivers = DB::table('employees')
        ->select('employees.employee_id', 'users.first_name', 'users.last_name')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->join('roles', 'roles.role_id', '=', 'users.role_id')
        ->where('roles.level', '=', 4)
        ->get();

        return view('create_roster', ['date' => $date, 'supervisors' => $supervisors, 'doctors' => $doctors, 'caregivers' => $caregivers])->with('level', session('level'));
    }

    //CreateRoster
    public function store(Request $request)
    {
        $roster = Roster::where('date', $request->roster_date)->first();

        if($roster) {
            return redirect()->back()->withErrors(['roster' => 'Roster Date Already in Use']);
        }

        Roster::create([
            'date' => $request->roster_date,
            'supervisor_id' => $request->supervisor_id,
            'doctor_id' => $request->doctor_id,
            'caregiver_id_1' => $request->caregiver_1_id,
            'caregiver_id_2' => $request->caregiver_2_id,
            'caregiver_id_3' => $request->caregiver_3_id,
            'caregiver_id_4' => $request->caregiver_4_id,
        ]);

        return redirect()->action([RosterController::class, 'create_roster_index']);

        
    }
}
