<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Displays login.blade.php
    }
    public function login(Request $request)
    {
        // Validate the  request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
    
        // Get the credentials from the request
        $email = $request->input('email');
        $password = $request->input('password');
    
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            // Authentication was successful, redirect the user to welcome page
            return view('welcome');

        } else {

            // Authentication failed, redirect back with an error
            return back()->with('error', 'Invalid credentials')->withInput();
        }
    }
}