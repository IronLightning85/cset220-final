<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showHome()
    {
        $roleId = Auth::user()->role_id; // check role in user
        return view('home', compact('roleId'));
    }
}

