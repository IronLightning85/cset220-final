<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    //Load Unapproved Users Admin Page
    public function showUnapprovedUsers()
    {
        // Fetch all users with an 'approved' status of 0 (unapproved users)
        $unapprovedUsers = User::where('approved', 0)->get();

        //Return Unapproved Users Admin Page
        return view('unapproved-users', compact('unapprovedUsers'))->with('level', session('level'));
    }

    //Approve User
    public function approveUser($id)
    {
        // Find the user by ID; if found, mark as approved
        $user = User::find($id);

        //Update and Save Value
        if ($user) {
            $user->approved = 1;
            $user->save();
        }
      
        //Redirect to showUnapprovedUsers function.
        return redirect()->route('unapproved-users')->with('status', 'User approved successfully.');
    }

    //Delete User
    public function denyUser($id)
    {
        // Find the user by ID
        $user = User::find($id);

      
        //Delete User
        if ($user) {
            // Determine the user's role and delete from the corresponding table
            switch ($user->role_id) {
                case 2:
                case 3:
                case 4:
                    // Delete from employees table
                    DB::table('employees')->where('user_id', $id)->delete();
                    break;
                case 5:
                    // Delete from family_members table
                    DB::table('family_members')->where('user_id', $id)->delete();
                    break;
                case 6:
                    // Delete from patients table
                    DB::table('patients')->where('user_id', $id)->delete();
                    break;
                default:
                    // No action needed for other roles
                    break;
            }
    
            // Delete the user record itself
            $user->delete();
        }


        //Redirect to showUnapprovedUsers function.
        return redirect()->route('unapproved-users')->with('status', 'User denied successfully.');
    }

    //Load Approved Users Page. Used to Change a User's Role
    public function showApprovedUsers()
    {
        // Fetch approved users and join with roles to get the role name
        $approvedUsers = User::where('approved', 1)
        ->leftJoin('roles', 'users.role_id', '=', 'roles.role_id')
        ->select('users.*', 'roles.role_name') // Select all user fields and role name
        ->get();

        //Return Approved Users Page
        return view('approved-users', ['approvedUsers' => $approvedUsers])->with('level', session('level'));
    }

    //Updates Role
    public function updateRole(Request $request, $id)
    {
        // Validate that 'role_id' is required and must be an integer
        $request->validate([
            'role_id' => 'required|integer',
        ]);

        // Find the user by ID
        $user = User::find($id);

        // Update the role only if the user is approved
        if ($user && $user->approved == 1) {
            $user->role_id = $request->role_id;
            $user->save();

            return redirect()->route('approved-users')->with('status', 'Role updated successfully.');
        }

        return redirect()->route('approved-users')->with('error', 'User not found or not approved.');
    }

    //Return JSON file of all currently available roles
    public function getAvailableRoles()
    {
        // Retrieve all roles excluding the role with role_id 1 (Admin)
        $roles = DB::table('roles')
                    ->where('role_id', '!=', 1)
                    ->get(['role_id', 'role_name']);

        return response()->json($roles);
    }

    public function showApprovedPatients()
    {
        // Get approved patients with their admission date and name
        $approvedPatients = DB::table('patients')
            ->join('users', 'patients.user_id', '=', 'users.user_id')
            ->leftJoin('patient_groups', 'patients.group_id', '=', 'patient_groups.group_id')
            ->where('users.approved', 1)
            ->select('patients.patient_id', 'patients.admission_date', 'users.first_name', 'users.last_name', 'patient_groups.group_id', 'patient_groups.name')
            ->get();

        $groups = DB::table('patient_groups')
            ->select('group_id', 'name')
            ->get();

        return view('approved-patients', compact('approvedPatients', 'groups'))->with('level', session('level'));
    }

    public function updateAdmissionDate(Request $request, $patient_id)
    {
        // Validate the date input
        $request->validate([
            'admission_date' => 'required|date',
            'group_id' => 'integer',
        ]);

        // Update the admission date for the specified patient
        DB::table('patients')
            ->where('patient_id', $patient_id)
            ->update(['admission_date' => $request->admission_date, 'group_id' => $request->group_id ]);

        return redirect()->route('approved-patients')->with('status', 'Admission date updated successfully.');
    }

    public function showPaymentPage(Request $request)
    {
        $userId = session('user_id'); // Retrieve user ID from session
        $patient = Patient::where('user_id', $userId)->first(); // Find patient by user ID
    
        if (!$patient) {
            abort(404, 'Patient record not found.');
        }
    
        // Render the payment-page view
        return view('payment-page', [
            'patient' => $patient,
        ])->with('level', session('level'));
    }
    
    public function processPayment(Request $request)
    {
        // Validate payment input
        $validatedData = $request->validate([
            'payment_amount' => 'required|numeric|min:1',
        ]);
    
        $userId = session('user_id'); // Get the logged-in user's ID
    
        // Find the patient record based on the foreign key `user_id`
        $patient = Patient::where('user_id', $userId)->first();
    
        if ($patient) {
            // Get the payment amount
            $paymentAmount = $validatedData['payment_amount'];
    
            // Ensure the payment amount does not exceed the total amount due
            $newTotalAmount = max(0, $patient->total_amount_due - $paymentAmount);
    
            // Update the patient's `total_amount_due`
            Patient::where('patient_id', $patient->patient_id)
                ->update(['total_amount_due' => $newTotalAmount]);
    
            return redirect()->route('payment')->with('status', 'Payment processed successfully.');
        }
    
        return redirect()->route('payment')->with('error', 'Patient record not found.');
    }
    
    public function applyDailyCharges()
    {
        // Retrieve the last system update
        $lastSystemUpdate = DB::table('settings')->where('key', 'last_update')->value('value');
        $currentDate = Carbon::now();
    
        // Fetch all patients with a valid admission date
        $patients = DB::table('patients')
            ->whereNotNull('admission_date')
            ->where('admission_date', '<=', $currentDate)
            ->get();
    
        foreach ($patients as $patient) {
            $lastCostUpdate = $patient->last_cost_update ?: $patient->admission_date;
    
            // Calculate days to charge for, ensuring no overcharges
            $daysToCharge = min(
                Carbon::parse($lastSystemUpdate)->diffInDays($lastCostUpdate),
                Carbon::parse($currentDate)->diffInDays($lastCostUpdate)
            );
    
            if ($daysToCharge > 0) {
                $totalCharge = $daysToCharge * 10; // $10 per day
    
                // Update the patient's total amount due
                DB::table('patients')
                    ->where('patient_id', $patient->patient_id)
                    ->update([
                        'total_amount_due' => DB::raw("total_amount_due + $totalCharge"),
                        'last_cost_update' => $currentDate,
                    ]);
            }
        }
    
        // Update the last system update timestamp
        DB::table('settings')
            ->where('key', 'last_update')
            ->update(['value' => $currentDate]);
    
        return redirect()->back()->with('success', 'Charges applied successfully.');
    }
}