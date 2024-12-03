<?php

namespace App\Http\Controllers;

use App\Models\roster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;




class RosterController extends Controller
{
    //Show Roster Page
    public function index()
    {
        $roster = Roster::where('date', date("Y/m/d"))->first();
        $date = date("Y/m/d");

        if (!$roster) {
            return view('roster', ['roster' => $roster, 'date' => $date])->withErrors(['roster' => 'No Roster Found for Selected Date'])->with('level', session('level'));
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

        $group_1 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_1)
        ->first();

        $group_2 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_2)
        ->first();

        $group_3 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_3)
        ->first();

        $group_4 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_4)
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
            'group_1' => $group_1,
            'group_2' => $group_2,
            'group_3' => $group_3,
            'group_4' => $group_4,
        ])->with('level', session('level'));    
    }
    
    public function specificDateRoster(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'roster_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors(['roster' => 'Invalid Date'])
            ->with('date', $request->roster_date);
        }

        $roster = Roster::where('date', $request->roster_date)->first();
        $date = $request->roster_date;

        
        if (!$roster) {
            return view('roster', ['roster' => $roster, 'date' => $date])->with('level', session('level'))->withErrors(['roster' => 'No Roster Found for Selected Date']);
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

        $group_1 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_1)
        ->first();

        $group_2 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_2)
        ->first();

        $group_3 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_3)
        ->first();

        $group_4 = DB::table('patient_groups')
        ->select('name')
        ->where('group_id', '=', $roster->group_id_4)
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
            'group_1' => $group_1,
            'group_2' => $group_2,
            'group_3' => $group_3,
            'group_4' => $group_4,
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

        $groups = DB::table('patient_groups')
        ->select('group_id', 'name')
        ->get();

        return view('create_roster', ['date' => $date, 'supervisors' => $supervisors, 'doctors' => $doctors, 'caregivers' => $caregivers, 'groups' => $groups])->with('level', session('level'));
    }

    //CreateRoster
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'roster_date' => 'required|date',
            'supervisor_id' => 'required|numeric',
            'doctor_id' => 'required|numeric',
            'caregiver_1_id' => 'required|numeric',
            'caregiver_2_id' => 'required|numeric',
            'caregiver_3_id' => 'required|numeric',
            'caregiver_4_id' => 'required|numeric',
            'group_id_1' => 'required|numeric',
            'group_id_2' => 'required|numeric',
            'group_id_3' => 'required|numeric',
            'group_id_4' => 'required|numeric',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors(['roster' => 'Invalid Inputs']);
        }
    
        $roster = Roster::where('date', $request->roster_date)->first();
    
        if ($roster) {
            return redirect()->back()->withErrors(['roster' => 'Roster Date Already in Use']);
        }
    
        // Create the new roster
        $roster = Roster::create([
            'date' => $request->roster_date,
            'supervisor_id' => $request->supervisor_id,
            'doctor_id' => $request->doctor_id,
            'caregiver_id_1' => $request->caregiver_1_id,
            'group_id_1' => $request->group_id_1,
            'caregiver_id_2' => $request->caregiver_2_id,
            'group_id_2' => $request->group_id_2,
            'caregiver_id_3' => $request->caregiver_3_id,
            'group_id_3' => $request->group_id_3,
            'caregiver_id_4' => $request->caregiver_4_id,
            'group_id_4' => $request->group_id_4,
        ]);
    
        // Fetch all admitted patients
        $patients = DB::table('patients')
            ->select('patient_id')
            ->whereNotNull('admission_date') // Ensure the patient is admitted
            ->get();
    
        // Insert patient_daily_activities entries for the specific date
        $data = [];
        foreach ($patients as $patient) {
            $data[] = [
                'patient_id' => $patient->patient_id,
                'morning' => 0,
                'afternoon' => 0,
                'night' => 0,
                'breakfast' => 0,
                'lunch' => 0,
                'dinner' => 0,
                'date' => $request->roster_date,
            ];
        }
    
        if (!empty($data)) {
            DB::table('patient_daily_activities')->insert($data);
        }
    
        return redirect()->action([RosterController::class, 'create_roster_index']);
    }
}
