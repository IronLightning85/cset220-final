<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    //Display Log In Page
    public function showLoginForm()
    {
        return view('login');
        $level = $user->role->level;
    }
    
    //User Log In
    public function login(Request $request)
    {
        //Validate Inputs
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        //Check If User is Approved
        $user = User::where('email', $request->email)->where('approved', 1)->first();

        if ($user && $request->password === $user->password) {
            $level = $user->role->level;
            return view('home', compact('level'));
        }

        return response()->json(['message' => 'Invalid login credentials or account not approved'], 401);
    }
}
