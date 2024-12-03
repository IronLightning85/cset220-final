<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //Display Log In Page
    public function showLoginForm()
    {
        if (session()->has('user_id')) {
            return redirect('/home');
        }

        return view('login')->with('level', session('level')); // Passing level to the view
    }

    //User Log In
    public function login(Request $request)
    {
        // Validate Inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Find the approved user by email
        $user = User::where('email', $request->email)->where('approved', 1)->first();
    
        // Check the password and ensure the user exists
        if ($user && Hash::check($request->password, $user->password)) {
            // Store the user's ID in the session
            session(['user_id' => $user->user_id]);

            session(['first_name' => $user->first_name]);
    
            // Store the user's level in the session (if needed)
            session(['level' => $user->role->level]);
    
            // Redirect to the home page
            return redirect('/home');
        }
    
        // Return error if login fails
        return redirect()->back()->withErrors(['login' => 'Invalid credentials or account not approved']);
    }

    public function logout(Request $request)
    {
        // Clear specific session keys
        $request->session()->forget(['level', 'user_id']);
        // Alternatively, clear all session data
        $request->session()->flush();
    
        // Redirect to the login page
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }

    
}
