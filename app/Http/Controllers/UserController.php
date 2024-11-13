<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function showUnapprovedUsers()
    {
        $unapprovedUsers = User::where('approved', 0)->get(); // Fetch all users with approved status 0
        return view('unapproved-users', compact('unapprovedUsers'));
    }

    public function approveUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->approved = 1;
            $user->save();
        }
        return redirect()->route('unapproved-users')->with('status', 'User approved successfully.');
    }

    public function denyUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
        }
        return redirect()->route('unapproved-users')->with('status', 'User denied successfully.');
    }
}