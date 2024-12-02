<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientDailyActivity;
use App\Models\Patient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CaregiverActivityController extends Controller
{
    // Display activities for patients in the caregiver's group
    public function showAllPatientsWithActivities()
    {
        // Fetch all patients with their daily activities
        $patients = DB::table('patients')
            ->leftJoin('users', 'patients.user_id', '=', 'users.user_id')
            ->leftJoin('patient_daily_activities', 'patients.patient_id', '=', 'patient_daily_activities.patient_id')
            ->select(
                'patients.patient_id',
                'users.first_name',
                'users.last_name',
                'patient_daily_activities.morning',
                'patient_daily_activities.afternoon',
                'patient_daily_activities.night',
                'patient_daily_activities.breakfast',
                'patient_daily_activities.lunch',
                'patient_daily_activities.dinner'
            )
            ->get();
    
        return view('daily_activities', compact('patients'))->with('level', session('level'));
    }

    public function updateDailyActivities(Request $request)
    {
        $activities = $request->input('activities', []);
    
        foreach ($activities as $patientId => $activity) {
            DB::table('patient_daily_activities')
                ->updateOrInsert(
                    ['patient_id' => $patientId],
                    [
                        'morning' => isset($activity['morning']),
                        'afternoon' => isset($activity['afternoon']),
                        'night' => isset($activity['night']),
                        'breakfast' => isset($activity['breakfast']),
                        'lunch' => isset($activity['lunch']),
                        'dinner' => isset($activity['dinner']),
                    ]
                );
        }
    
        return redirect()->back()->with('success', 'Daily activities updated successfully.');
    }
}