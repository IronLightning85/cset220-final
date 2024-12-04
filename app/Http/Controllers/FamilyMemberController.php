<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\Patient;
use App\Models\PatientDailyActivity;
use Validator;

class FamilyMemberController extends Controller
{
    /**
     * Display the family member page.
     */
    public function index()
    {
        return view('family');
    }

    /**
     * Handle form submission for a specific date.
     */
    public function specificDateFamily(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'family_date' => 'required|date',
            'family_code' => 'required|string',
            'patient_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors($validator);
        }

        // Fetch family member by family code
        $family = FamilyMember::where('family_code', $request->family_code)->first();

        // Fetch patient by ID
        $patient = Patient::find($request->patient_id);

        if (!$family || !$patient) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Invalid family code or patient ID.']);
        }

        // Fetch daily activities for the patient and date
        $dailyActivities = PatientDailyActivity::where('patient_id', $patient->id)
            ->whereDate('date', $request->family_date)
            ->get();

        if ($dailyActivities->isEmpty()) {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'No activities found for the selected date.']);
        }

        // Return the view with patient data
        return view('family', [
            'family' => $family,
            'patients' => $dailyActivities,
            'date' => $request->family_date,
        ]);
    }
}
