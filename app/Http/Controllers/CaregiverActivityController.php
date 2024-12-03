<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PatientDailyActivity;
use App\Models\Patient;
use Illuminate\Support\Facades\DB;

class CaregiverActivityController extends Controller
{
    // Display activities for patients in the caregiver's group
    public function showAllPatientsWithActivities()
    {
        // Get the caregiver's user_id from the session
        $userId = session('user_id');

        // Query the employees table to get the employee_id
        $caregiverId = DB::table('employees')
            ->where('user_id', $userId)
            ->value('employee_id');

        // Fetch the caregiver's assigned group for the current date from the rosters table
        $today = now()->toDateString();
        $caregiverGroup = DB::table('rosters')
            ->where('date', $today)
            ->where(function ($query) use ($caregiverId) {
                $query->where('caregiver_id_1', $caregiverId)
                    ->orWhere('caregiver_id_2', $caregiverId)
                    ->orWhere('caregiver_id_3', $caregiverId)
                    ->orWhere('caregiver_id_4', $caregiverId);
            })
            ->select(DB::raw("
                CASE
                    WHEN caregiver_id_1 = {$caregiverId} THEN group_id_1
                    WHEN caregiver_id_2 = {$caregiverId} THEN group_id_2
                    WHEN caregiver_id_3 = {$caregiverId} THEN group_id_3
                    WHEN caregiver_id_4 = {$caregiverId} THEN group_id_4
                END AS group_id
            "))
            ->first();

        // If no group is assigned, return an empty patient list
        if (!$caregiverGroup) {
            $patients = [];
            return view('daily_activities', compact('patients'))->with('level', session('level'));
        }

        // Fetch all patients in the caregiver's assigned group with their daily activities
        $patients = Patient::where('group_id', $caregiverGroup->group_id)
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

    // Update daily activities for patients
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
