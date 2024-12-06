<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FamilyMember;
use App\Models\Patient;
use App\Models\PatientDailyActivity;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class FamilyMemberController extends Controller
{
    /**
     * Display the family member page.
     */
    public function index()
    {
        return view('family')->with('level', session('level'));
    }

    /**
     * Handle form submission for a specific date.
     */
    public function specificDateFamily(Request $request)
    {
        // Validate input
        $validator = Validator::make($request->all(), [
            'family_code' => 'required|string|max:255',
            'patient_id' => 'required|integer',
            'family_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('level', session('level'));
        }

        // Format the date
        $date = Carbon::parse($request->input('family_date'))->format('Y-m-d');

        try {
            // Fetch patient daily activities for the specific date
            $activities = DB::table('patient_daily_activities')
                ->join('patients', 'patient_daily_activities.patient_id', '=', 'patients.patient_id')
                ->join('users', 'patients.user_id', '=', 'users.user_id')
                ->where('patient_daily_activities.date', $date)
                ->where('patients.family_code', $request->family_code)
                ->where('patients.patient_id', $request->patient_id)
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

            // Check if no activities are found
            if ($activities->isEmpty()) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['error' => 'No activities found for the selected date.']);
            }

            // Return the same view with the fetched data
            return view('family', [
                'activities' => $activities,
                'date' => $date,
            ])->with('level', session('level'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'An error occurred while fetching data.'])->withInput()->with('level', session('level'));
        }
    }
}
