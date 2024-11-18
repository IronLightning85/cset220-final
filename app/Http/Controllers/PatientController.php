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
        ->whereNotNull('patients.admission_date')
        ->get();

        foreach ($patients as $patient) {
            $patient->age = Carbon::parse($patient->dob)->age;
        }
        
        return view('patients', ['patients' => $patients]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Display Patients Page
        $patients = DB::table('patients')
        ->join('users', 'patients.user_id', '=', 'users.user_id')
        ->whereNotNull('patients.admission_date')
        ->get();

        $search_patients = [];

        foreach ($patients as $patient) {
            $patient->age = Carbon::parse($patient->dob)->age;
            $patient->full_name = $patient->first_name . " " . $patient->last_name;
            $patient->date = Carbon::parse($patient->admission_date)->toDateString();

            //SEARCH function searches in order of inputs on page. Searches by id first, if id is invalid or not used, it will move to name and so on
            //Else Statements so its not one big IF line
            //Could probably be optimized so it just searches the database using these requirements
            if($request->patient_id && $patient->patient_id == $request->patient_id) {
                $search_patients[] = $patient;
            }

            else if($request->admission_date && $patient->date == $request->admission_date) {
                $search_patients[] = $patient;
            }

            else if($request->name && $patient->full_name == $request->name) {
                $search_patients[] = $patient;
            }

            else if($request->age && $patient->age == $request->age) {
                $search_patients[] = $patient;
            }

            else if($request->emergency_contact && $patient->emergency_contact == $request->emergency_contact) {
                $search_patients[] = $patient;
            }
            
            else if($request->age && $patient->age == $request->age) {
                $search_patients[] = $patient;
            }

            else if($request->emergency_contact_relation && $patient->contact_relation == $request->emergency_contact_relation) {
                $search_patients[] = $patient;
            }

        }


        return view('patients', ['patients' => $search_patients]);
    }

}
