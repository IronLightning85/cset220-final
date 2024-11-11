<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        $user = User::where('email', $request->email)->where('approved', 1)->first();
    
        if ($user && Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json(['message' => 'Login successful', 'user' => $user]);
        }
    
        return response()->json(['message' => 'Invalid login credentials or account not approved'], 401);
    }

    public function getUser(Request $request)
    {
        if (Auth::check()) {
            return response()->json(Auth::user());
        }

        return response()->json(['message' => 'Not authenticated'], 401);
    }
}
