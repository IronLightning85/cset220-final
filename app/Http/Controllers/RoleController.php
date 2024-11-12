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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = DB::table('roles')->get();

    
        return response()->json([
            'success' => true,
            'data' => $roles
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $account= role::create([
            'role_name' => $request->role_name,
            'level' => $request->level,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Created successfully',
            'data' => $account
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(role $role)
    {
        //
    }
}
