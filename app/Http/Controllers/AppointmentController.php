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
                ->where(function ($query) {
                    $query->where('date', '<', now()->toDateString())
                          ->orWhereNotNull('comment');
                })
                ->orderBy('date', 'asc')
                ->limit(10)
                ->select('appointments.*', 'users.first_name', 'users.last_name')
                ->get();

            $appointments_upcoming = DB::table('appointments')
                ->join('patients', 'appointments.patient_id', '=', 'patients.patient_id')
                ->join('users', 'patients.user_id', '=', 'users.user_id')
                ->where('doctor_id', '=', $employee_id)
                ->where('date', '>=', now()->toDateString())
                ->whereNull('comment')
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

    public function view_appointment_get()
    {
        return redirect()->action([self::class, 'doctorIndex']);
    }



    public function view_appointment_index(Request $request)
    {
        //Validate appointment id
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|numeric|exists:appointments,appointment_id',
        ]);

        //Return to last page if validator fails
        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors(['input' => 'Invalid Appointment. Please Contact Admin'])            
            ->withInput();
        }

        //grab current appointment info
        $current_appointment = DB::table('appointments')
            ->where('appointment_id', $request->appointment_id)
            ->first();

        //Get appointment info and display
        $previous_appointment = db::table('appointments')
            ->where('patient_id', $current_appointment->patient_id)
            ->where('date', '<', $current_appointment->date)
            ->orderBy('date', 'desc')
            ->first();


        return view('view-appointment', ['current_appointment' => $current_appointment,'appointment_id' => $request->appointment_id, 'previous_appointment' => $previous_appointment])->with('level', session('level')); 
    }


    public function view_appointment_store(Request $request)
    {
        //Validate appointment id
        $validator = Validator::make($request->all(), [
            'appointment_id' => 'required|numeric|exists:appointments,appointment_id',
            'comment' => 'required',
            'morning_med' => 'required',
            'afternoon_med' => 'required',
            'night_med' => 'required',
        ]);

        //Return to last page if validator fails
        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors(['input' => 'Invalid Appointment or missing inputs Please Contact Admin'])            
            ->withInput();
        }

        // Update the appointment with the new data
        $appointment = DB::table('appointments')
            ->where('appointment_id', $request->input('appointment_id'))
            ->update([
                'comment' => $request->input('comment'),
                'morning_med' => $request->input('morning_med'),
                'afternoon_med' => $request->input('afternoon_med'),
                'night_med' => $request->input('night_med'),
            ]);

        if ($appointment) {
            // Redirect to success page with a success message
            return redirect()->route('doctors-home.'); // Adjust to your appointments route
        } 
        else 
        {
            // If update failed
            return redirect()
                ->back()
                ->withErrors(['input' => 'Failed to update appointment. Please try again.'])
                ->withInput();
        }


    }

}

