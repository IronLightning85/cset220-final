<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\Patient;

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
            ->where('users.approved', 1)
            ->select('patients.patient_id', 'patients.admission_date', 'users.first_name', 'users.last_name')
            ->get();

        return view('approved-patients', compact('approvedPatients'))->with('level', session('level'));
    }

    public function updateAdmissionDate(Request $request, $patient_id)
    {
        // Validate the date input
        $request->validate([
            'admission_date' => 'required|date',
        ]);

        // Update the admission date for the specified patient
        DB::table('patients')
            ->where('patient_id', $patient_id)
            ->update(['admission_date' => $request->admission_date]);

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
    
        $user = auth()->user(); // Get the logged-in user
        $patient = Patient::where('user_id', $user->user_id)->first(); // Find the patient
    
        if ($patient) {
            // Ensure the payment amount does not exceed the total amount due
            $paymentAmount = $validatedData['payment_amount'];
    
            // Calculate the new total amount due
            $newTotalAmount = max(0, $patient->total_amount_due - $paymentAmount);
    
            // Update the patient's total amount due
            $patient->update(['total_amount_due' => $newTotalAmount]);
    
            return redirect()->route('payment')->with('status', 'Payment processed successfully.');
        }
    
        return redirect()->route('payment')->with('error', 'Patient record not found.');
    }
}