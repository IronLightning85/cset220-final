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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return all users who have not been approved
        //$users = user::find()->where('approved', false)->get();
        $users = DB::table('users')->where('approved', false)->get();

    
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
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
        //validate basic user data
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'dob' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'role_id' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        

        
        //insert into user table
        $account= user::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'email' => $request->email,
            'password' => $request->password,
            'role_id' => $request->role_id,
        ]);


        //insert into table depending on role
        if ($request->role_id > 0 && $request->role_id < 5) {
            DB::table('employees')->insert([
                'user_id' => $account->id,
                'salary' => 50000.00,

            ]);
        }
    
        else if ($request->role_id == 5) {
            //validate family member data
            $validator = Validator::make($request->all(), [
                'patient_relation' => 'required',
            ]);
    
            //return to previous page and delete new user row
            if ($validator->fails()) {
                $account->delete();

                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            else {
                //insert into family member table
                DB::table('family_members')->insert([
                    'patient_relation' => $request->patient_relation,
                    'user_id' => $account->user_id,
    
                ]);
            }
            
        }

        else if ($request->role_id == 6) {
            //validate patient data
            $validator = Validator::make($request->all(), [
                'emergency_contact' => 'required',
                'contact_relation' => 'required',
                'family_code' => 'required',
            ]);
    
            //return to last page and delete new user row
            if ($validator->fails()) {
                $account->delete();

                return redirect()->back()
                ->withErrors($validator)
                ->withInput();
            }

            else {
                //insert into patients table
                DB::table('patients')->insert([
                    'user_id' => $account->user_id,
                    'emergency_contact' => $request->emergency_contact,
                    'contact_relation' => $request->contact_relation,
                    'family_code' => $request->family_code,
    
                ]);
            }

            
        }
        
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
