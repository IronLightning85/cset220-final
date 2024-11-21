<?php

namespace App\Http\Controllers;

use App\Models\employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;



class EmployeeController extends Controller
{
    //Display all Employees
    public function index()
    {
        $employees = DB::table('employees')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->join('roles', 'users.role_id', '=', 'roles.role_id')
        ->get();
        
        return view('employees', ['employees' => $employees])->with('level', session('level'));
    }

    //Store a new salary, then display all employee
    public function store(Request $request)
    {
        //Validate Data
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required',
            'salary' => 'required',
        ]);

        //Return to last page if validator fails
        if ($validator->fails()) {
            return redirect()->back()
            ->withErrors($validator)
            ->withInput();
        }
        
        //Update Employee Salary
        $employee = employee::find($request->employee_id);
        $employee->salary = $request->salary;
        $employee->save();


        //Display Employee Page
        $employees = DB::table('employees')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->join('roles', 'users.role_id', '=', 'roles.role_id')
        ->get();
        
        return view('employees', ['employees' => $employees]);
    }
}
