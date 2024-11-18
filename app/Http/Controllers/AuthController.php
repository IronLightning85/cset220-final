<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    //Display Log In Page
    public function showLoginForm()
{
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
    
        if ($user && $request->password === $user->password) {
            // Store the user's level in the session
            session(['level' => $user->role->level]);
    
            // Redirect to the home page
            return redirect('/home');
        }
    
        // Return error if login fails
        return redirect()->back()->withErrors(['login' => 'Invalid credentials or account not approved']);
        'Error Login Failed / Not approved';
    }
    public function logout(Request $request)
    {
        // Clear the session
        $request->session()->flush(); // Removes all session data

        // Redirect to the login page
        return redirect('/login')->with('message', 'You have been logged out successfully.');
    }


}
