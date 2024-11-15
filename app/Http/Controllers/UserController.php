<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //Load Unapproved Users Admin Page
    public function showUnapprovedUsers()
    {
        // Fetch all users with an 'approved' status of 0 (unapproved users)
        $unapprovedUsers = User::where('approved', 0)->get();

        //Return Unapproved Users Admin Page
        return view('unapproved-users', compact('unapprovedUsers'));
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
    
            // Check if the user's role ID is 6 (Patient)
            if ($user->role_id == 6) {
                // Update the admission_date in the patients table with the current timestamp
                DB::table('patients')
                    ->where('user_id', $id)
                    ->update(['admission_date' => now()]);
            }
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
        return view('approved-users', ['approvedUsers' => $approvedUsers]);
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
}