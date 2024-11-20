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
            return view('roster', ['roster' => $roster, 'date' => $date]);
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
        ]);    
    }
    
    public function specificDateRoster(Request $request) 
    {
        $roster = Roster::where('date', $request->roster_date)->first();
        $date = $request->roster_date;

        
        if (!$roster) {
            return view('roster', ['roster' => $roster, 'date' => $date]);
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
        ]); 
    }

    //Creating Roster Page
    public function store(Request $request)
    {
        //
    }
}
