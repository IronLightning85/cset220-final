<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\role;
use Illuminate\Http\Request;


class RoleController extends BaseController
{
    //Load Add Roles Admin Page
    public function index()
    {
        //Get All Role Data
        $roles = DB::table('roles')->get();

        //Return Add Roles Page
        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    //Store New Role
    public function store(Request $request)
    {
        //Valide Data
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
            'role_level' => 'required',
        ]);

        //Return to Roles Page if Validation Fails
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }

        //Insert New Role Data
        else {
            $account= role::create([
                'role_name' => $request->role_name,
                'level' => $request->level,
            ]);

        }

        //Return Add Roles Page
        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $account
        ], 201);
    }
}
