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
        //
    }

}
