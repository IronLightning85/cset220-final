<?php

namespace App\Http\Controllers;

use App\Models\appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class AppointmentController extends Controller
{
    public function index()
    {
        return view('appointment')->with('level', session('level'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|numeric|exists:patients,patient_id',
            'appointment_date' => 'required|date',
            'doctor_id' => 'required|numeric|exists:employees,employee_id',

        ]);

        //Return to last page if validator fails
        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors(['validator' => 'Invalid Inputs'])            
            ->withInput();
        }

        $appointment= appointment::create([
            'date' => $request->appointment_date,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
        ]);

        return view('appointment')->with('level', session('level'));
    }

    //Used to select Doctor who is on roster for selected date. uses ajax
    public function getDoctorsByDate($date)
    {
        $doctors = DB::table('rosters')
            ->join('employees', 'rosters.doctor_id', '=', 'employees.employee_id')
            ->join('users', 'employees.user_id', '=', 'users.user_id')
            ->join('roles', 'roles.role_id', '=', 'users.role_id')
            ->where('roles.level', '=', '3')//grabs doctor/permission equivalent role
            ->where('rosters.date', '=', $date)
            ->select('employees.employee_id', 'users.first_name', 'users.last_name')
            ->get();

        // Format the result to include full name (optional)
        $formattedDoctors = $doctors->map(function ($doctor) {
            return [
                'employee_id' => $doctor->employee_id,
                'name' => "{$doctor->first_name} {$doctor->last_name}",
            ];
        });

        return response()->json($formattedDoctors);
    }

    public function getPatientDetails($patientId)
    {

        // Fetch the patient details using the patient ID
        $patient = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.user_id')
            ->where('patients.patient_id', '=', $patientId)
            ->select("patients.patient_id", "users.first_name", "users.last_name")
            ->first(); // Use first() to get a single record
        
        if ($patient) {
            return response()->json([
                'patient_id' => $patient->patient_id,
                'first_name' => $patient->first_name,
                'last_name' => $patient->last_name,
            ]);
        } else {
            return response()->json(['error' => 'Patient not found'], 404);
        }

    }

    //Doctors Home functions
    public function doctorIndex() 
    {
        $user_id = session('user_id');
        $employee = db::table('users')
        ->join('employees', 'users.user_id', '=', 'employees.user_id')
        ->select('employee_id')
        ->first();
        dd($employee);



        if ($employee) {
            $employee_id = $employee->employee_id; // Extract the employee_id value
            dd($employee_id);
        
            // Fetch old appointments
            $appointments_old = DB::table('appointments')
                ->where('doctor_id', '=', $employee_id) // Use the extracted value
                ->where('date', '<', now()->toDateString())
                ->orderBy('date', 'desc') // Order by the date in descending order
                ->limit(10)
                ->get();

            $appointments_upcoming = DB::table('appointments')
            ->where('doctor_id', '=', $employee_id)
            ->where('date', '>=', now()->toDateString()) // Start from the beginning of today
            ->orderBy('date', 'desc') // Order by the date in descending order
            ->get(); // Fetch all matching results

            return view('doctors-home', [
                'appointments_old' => $appointments_old,
                'appointments_upcoming' => $appointments_upcoming,
                'level' => session('level')
            ]);

        }
        else {
            return view('doctors-home')->withErrors(['error' => 'Error finding your information. Please contact our representative'])->with('level', session('level'));            
        }
    }
}

