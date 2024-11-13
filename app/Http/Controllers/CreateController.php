<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Log;

class CreateController extends Controller
{
    public function showRegistrationForm()
    {
        // Retrieve roles, excluding "Admin" role if necessary
        $roles = Role::where('role_name', '!=', 'Admin')->get();
        return view('register', compact('roles'));
    }

    public function register(Request $request)
    {
        // Retrieve valid role IDs from the roles table
        $roleIds = Role::pluck('role_id')->toArray();

        try {
            $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone' => 'required|string|max:20',
                'dob' => 'required|date',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:8|confirmed',
                'role_id' => 'required|integer|in:' . implode(',', $roleIds),

            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation errors: ', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        // Create the user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        Log::info("User created: ", $user->toArray());

        return response()->json([
            'message' => 'Account created successfully',
            'user' => $user,
        ], 201);
    }
}
