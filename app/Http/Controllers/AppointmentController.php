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
        ->select('employees.employee_id')
        ->where('users.user_id', $user_id)
        ->first();

        if ($employee) {
            $employee_id = $employee->employee_id;
        
            // Fetch old appointments
            $appointments_old = DB::table('appointments')
                ->join('patients', 'appointments.patient_id', '=', 'patients.patient_id')
                ->join('users', 'patients.user_id', '=', 'users.user_id')
                ->where('doctor_id', '=', $employee_id)
                ->where('date', '<', now()->toDateString())
                ->orderBy('date', 'asc')
                ->limit(10)
                ->select('appointments.*', 'users.first_name', 'users.last_name')
                ->get();

            $appointments_upcoming = DB::table('appointments')
                ->join('patients', 'appointments.patient_id', '=', 'patients.patient_id')
                ->join('users', 'patients.user_id', '=', 'users.user_id')
                ->where('doctor_id', '=', $employee_id)
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date', 'asc')
                ->select('appointments.*', 'users.first_name', 'users.last_name')
                ->get();

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


    public function filterAppointments(Request $request){

        $user_id = session('user_id');
        $employee = db::table('users')
        ->join('employees', 'users.user_id', '=', 'employees.user_id')
        ->select('employees.employee_id')
        ->where('users.user_id', $user_id)
        ->first();

        if ($employee) {
            $employee_id = $employee->employee_id;
        
            // Fetch old appointments and filter it
            $appointments_old_query = DB::table('appointments')
                ->join('patients', 'appointments.patient_id', '=', 'patients.patient_id')
                ->join('users', 'patients.user_id', '=', 'users.user_id')
                ->where('doctor_id', '=', $employee_id)
                ->where('date', '<', now()->toDateString())
                ->orderBy('date', 'asc')
                ->limit(10)
                ->select('appointments.*', 'users.first_name', 'users.last_name');

            if ($request->filled('patient_name')) {
                $appointments_old_query->where(DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), 'like', '%' . $request->patient_name . '%');
            }

            if ($request->filled('date')) {
                $appointments_old_query->where('date', '=', $request->date);
            }

            if ($request->filled('comment')) {
                $appointments_old_query->where('comment', 'like', '%' . $request->comment . '%');
            }

            if ($request->filled('morning_med')) {
                $appointments_old_query->where('morning_med', 'like', '%' . $request->morning_med . '%');
            }
        
            if ($request->filled('afternoon_med')) {
                $appointments_old_query->where('afternoon_med', 'like', '%' . $request->afternoon_med . '%');
            }
        
            if ($request->filled('night_med')) {
                $appointments_old_query->where('night_med', 'like', '%' . $request->night_med . '%');
            }

            $appointments_old = $appointments_old_query->get();

            //upcoming appointments and filter
            $appointments_upcoming_query = DB::table('appointments')
                ->join('patients', 'appointments.patient_id', '=', 'patients.patient_id')
                ->join('users', 'patients.user_id', '=', 'users.user_id')
                ->where('doctor_id', '=', $employee_id)
                ->where('date', '>=', now()->toDateString())
                ->orderBy('date', 'asc')
                ->select('appointments.*', 'users.first_name', 'users.last_name');

            if ($request->filled('patient_name')) {
                $appointments_upcoming_query->where(DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), 'like', '%' . $request->patient_name . '%');
            }

            if ($request->filled('date')) {
                $appointments_upcoming_query->where('date', '=', $request->date);
            }

            if ($request->filled('comment')) {
                $appointments_upcoming_query->where('comment', 'like', '%' . $request->comment . '%');
            }

            if ($request->filled('morning_med')) {
                $appointments_upcoming_query->where('morning_med', 'like', '%' . $request->morning_med . '%');
            }
        
            if ($request->filled('afternoon_med')) {
                $appointments_upcoming_query->where('afternoon_med', 'like', '%' . $request->afternoon_med . '%');
            }
        
            if ($request->filled('night_med')) {
                $appointments_upcoming_query->where('night_med', 'like', '%' . $request->night_med . '%');
            }

            $appointments_upcoming = $appointments_upcoming_query->get();


            return view('doctors-home', [
                'appointments_old' => $appointments_old,
                'appointments_upcoming' => $appointments_upcoming,
                'level' => session('level')
            ]);
        }
        
        return view('doctors-home')->withErrors(['error' => 'Error finding your information. Please contact our representative'])->with('level', session('level'));            
    }

}

