<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Validator;


class Controller extends BaseController
{

    use AuthorizesRequests, ValidatesRequests;


    //Display Register Page
    public function showRegistrationForm()
    {
        // Retrieve roles, excluding "Admin" role
        $roles = DB::table('roles')->where('role_id', '>', 1)->get();

        return view('register', ['roles' => $roles]);
    }

    //Create a New User
    public function store(Request $request)
    {
        //Validate User Table Data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        //Return to Register Page on Fail
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        
        //Inser User Data to User Table
        $account= user::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id,
        ]);

        //Insert Remaining Data depending on Selected Role
        //Employee Table Insert
        if ($request->role_id > 0 && $request->role_id < 5) {
            DB::table('employees')->insert([
                'user_id' => $account->user_id,
                'salary' => 50000.00,

            ]);
        }
    
        //Family Member Insertion
        else if ($request->role_id == 5) {

            //Validate Family Member Data
            $validator = Validator::make($request->all(), [
                'patient_relation' => 'required',
            ]);
    
            //Delete New User Table Row and Return to Register Page on Fail
            if ($validator->fails()) {
                $account->delete();

                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            //Insert Family Member Data
            else {
                DB::table('family_members')->insert([
                    'patient_relation' => $request->patient_relation,
                    'user_id' => $account->user_id,
    
                ]);
            }
            
        }

        //Patient Data Insertion
        else if ($request->role_id == 6) {

            //Validate Patient Insertion
            $validator = Validator::make($request->all(), [
                'emergency_contact' => 'required',
                'contact_relation' => 'required',
                'family_code' => 'required',
            ]);
    
            //Return to Register Page and Delete New User Row
            if ($validator->fails()) {
                $account->delete();

                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            else {
                //Insert Patient Data
                DB::table('patients')->insert([
                    'user_id' => $account->user_id,
                    'emergency_contact' => $request->emergency_contact,
                    'contact_relation' => $request->contact_relation,
                    'family_code' => $request->family_code,
    
                ]);
            }

            
        }
        
        //Return to Index Page
        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $account
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(family_member $family_member)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(family_member $family_member)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, family_member $family_member)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(family_member $family_member)
    {
        //
    }
}
