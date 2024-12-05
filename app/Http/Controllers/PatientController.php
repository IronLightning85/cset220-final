<?php

namespace App\Http\Controllers;

use App\Models\patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; // Import Carbon for date handling

class PatientController extends Controller
{
    //Display Patients Page
    public function index()
    {
        $patients = DB::table('patients')
        ->join('users', 'patients.user_id', '=', 'users.user_id')
        ->where('users.approved', '=', '1')
        ->whereNotNull('patients.admission_date')
        ->get();

        foreach ($patients as $patient) {
            $patient->age = Carbon::parse($patient->dob)->age;
        }
        
        return view('patients', ['patients' => $patients])->with('level', session('level'));
    }

    //Search for Patients
    public function store(Request $request)
    {
        {
            $patientsQuery = DB::table('patients')
                ->join('users', 'patients.user_id', '=', 'users.user_id')
                ->where('users.approved', '=', '1')
                ->whereNotNull('patients.admission_date')
                ->select(
                    'patients.*', 
                    'users.first_name', 
                    'users.last_name', 
                    'users.dob', 
                );
        
            // Apply filters if provided
            if ($request->patient_id) {
                $patientsQuery->where('patients.patient_id', $request->patient_id);
            }

            if ($request->admission_date) {
                $patientsQuery->whereRaw('DATE(patients.admission_date) = ?', [$request->admission_date]);            
            }

            if ($request->name) {
                $patientsQuery->where(DB::raw("CONCAT(users.first_name, ' ', users.last_name)"), 'like', '%' . $request->name . '%');
            }

            if ($request->age) {
                $patientsQuery->whereRaw('TIMESTAMPDIFF(YEAR, users.dob, CURDATE()) = ?', [$request->age]);
            }

            if ($request->emergency_contact) {
                $patientsQuery->where('patients.emergency_contact', 'like', '%' . $request->emergency_contact . '%');            
            }

            if ($request->emergency_contact_relation) {
                $patientsQuery->where('patients.contact_relation', 'like', '%' . $request->emergency_contact_relation . '%');
            }
        
            // Fetch filtered patients
            $patients = $patientsQuery->get();
        
            // Add additional fields (full name, age)
            foreach ($patients as $patient) {
                $patient->full_name = $patient->first_name . " " . $patient->last_name;
                $patient->age = Carbon::parse($patient->dob)->age;
                $patient->date = Carbon::parse($patient->admission_date)->toDateString();
            }
        
            // Check if any results were found
            if ($patients->isEmpty()) {
                return view('patients', ['patients' => $patients])
                    ->with('level', session('level'))
                    ->withErrors(['patient' => 'No Patients Found']);
            }
        
            return view('patients', ['patients' => $patients])->with('level', session('level'));
        }
}

}
