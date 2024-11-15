<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showHome()
    {
        // Retrieve the logged-in user and load the related role with the level
        $user = Auth::user();
        $level = $user->role->level; // Access the level from the related role

        // Pass the level to the view
        return view('home', compact('level'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // Other methods for your application (e.g., showRoster, etc.)
}
