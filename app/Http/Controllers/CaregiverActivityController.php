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
    
        // Fetch all patients in the caregiver's assigned group with their daily activities for today
        $patients = DB::table('patients')
            ->where('patients.group_id', $caregiverGroup->group_id)
            ->join('users', 'patients.user_id', '=', 'users.user_id')
            ->leftJoin('patient_daily_activities', function ($join) use ($today) {
                $join->on('patients.patient_id', '=', 'patient_daily_activities.patient_id')
                     ->where('patient_daily_activities.date', '=', $today);
            })
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
    
        // Return the view with the patients and caregiver level
        return view('daily_activities', compact('patients'))->with('level', session('level'));
    }

    // Update daily activities for patients
    public function updateDailyActivities(Request $request)
    {
        $activities = $request->input('activities', []);
        $today = now()->toDateString();
    
        foreach ($activities as $patientId => $activity) {
            DB::table('patient_daily_activities')
                ->updateOrInsert(
                    ['patient_id' => $patientId, 'date' => $today],
                    [
                        'morning' => isset($activity['morning']),
                        'afternoon' => isset($activity['afternoon']),
                        'night' => isset($activity['night']),
                        'breakfast' => isset($activity['breakfast']),
                        'lunch' => isset($activity['lunch']),
                        'dinner' => isset($activity['dinner']),
                        'updated_at' => now(),
                    ]
                );
        }
    
        return redirect()->back()->with('success', 'Daily activities updated successfully for today.');
    }

    public function showActivitiesForDate(Request $request)
    {
        $date = $request->input('date', now()->toDateString()); // Default to today if no date is selected

        // Fetch all patients and their daily activities for the selected date
        $activities = DB::table('patient_daily_activities')
            ->join('patients', 'patient_daily_activities.patient_id', '=', 'patients.patient_id')
            ->join('users', 'patients.user_id', '=', 'users.user_id')
            ->where('patient_daily_activities.date', $date)
            ->select(
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

        return view('activities_for_date', compact('activities', 'date'))->with('level', session('level'));
    }

    public function showPatientDailyActivities(Request $request)
    {
        // Get the logged-in user's ID
        $userId = session('user_id');
        
        // Fetch patient details from the 'patients' table
        $patient = DB::table('patients')->where('user_id', $userId)->first();

        // Fetch the user's full name from the 'users' table
        $user = DB::table('users')->where('user_id', $userId)->first();
    
        // If the user is not a patient, redirect back with an error
        if (!$patient) {
            return redirect()->back()->with('error', 'You are not authorized to view this page.');
        }
    
        // Get the selected date, or use today's date as the default
        $date = $request->input('date', now()->toDateString());
    
        // Fetch the roster for the given date and group_id
        $roster = DB::table('rosters')
            ->where('date', $date)
            ->where(function ($query) use ($patient) {
                $query->where('group_id_1', $patient->group_id)
                      ->orWhere('group_id_2', $patient->group_id)
                      ->orWhere('group_id_3', $patient->group_id)
                      ->orWhere('group_id_4', $patient->group_id);
            })
            ->select('doctor_id', 'group_id_1', 'caregiver_id_1', 'group_id_2', 'caregiver_id_2', 'group_id_3', 'caregiver_id_3', 'group_id_4', 'caregiver_id_4')
            ->first();
    
        // If no roster is found for the day, return an empty view
        if (!$roster) {
            return view('patient_daily_activities', [
                'activities' => [],
                'date' => $date,
                'doctorName' => 'N/A',
                'caregiverName' => 'N/A',
                'patient' => $patient,
                'user' => $user,
            ])->with('level', session('level'));
        }
    
        // Find the doctor name from the employees and users tables
        $doctorName = DB::table('employees')
            ->join('users', 'employees.user_id', '=', 'users.user_id')
            ->where('employees.employee_id', $roster->doctor_id)
            ->select(DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"))
            ->value('name');
    
        // Determine which caregiver is assigned to the patient's group
        $caregiverId = null;
        if ($patient->group_id == $roster->group_id_1) {
            $caregiverId = $roster->caregiver_id_1;
        } elseif ($patient->group_id == $roster->group_id_2) {
            $caregiverId = $roster->caregiver_id_2;
        } elseif ($patient->group_id == $roster->group_id_3) {
            $caregiverId = $roster->caregiver_id_3;
        } elseif ($patient->group_id == $roster->group_id_4) {
            $caregiverId = $roster->caregiver_id_4;
        }
    
        // Find the caregiver name
        $caregiverName = $caregiverId
            ? DB::table('employees')
                ->join('users', 'employees.user_id', '=', 'users.user_id')
                ->where('employees.employee_id', $caregiverId)
                ->select(DB::raw("CONCAT(users.first_name, ' ', users.last_name) AS name"))
                ->value('name')
            : 'N/A';
    
        // Get the patient's daily activities for the selected date
        $activities = DB::table('patient_daily_activities')
            ->where('patient_id', $patient->patient_id)
            ->where('date', $date)
            ->select('morning', 'afternoon', 'night', 'breakfast', 'lunch', 'dinner')
            ->first();
    
        // Return the view with the data
        return view('patient_daily_activities', [
            'activities' => $activities,
            'date' => $date,
            'doctorName' => $doctorName,
            'caregiverName' => $caregiverName,
            'patient' => $patient,
            'user' => $user,
        ])->with('level', session('level'));
    }
}
