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
        ->where('users.approved', '=', '1')
        ->get();
        
        return view('employees', ['employees' => $employees])->with('level', session('level'));
    }

    //Store a new salary, then display all employee
    public function store(Request $request)
    {
        //Validate Data
        $validator = Validator::make($request->all(), [
            'employee_id' => 'required|numeric|exists:employees,employee_id',
            'salary' => 'required|numeric',
        ]);

        //Return to last page if validator fails
        if ($validator->fails()) {
            return redirect()
            ->back()
            ->withErrors(['input' => 'Invalid Inputs'])            
            ->withInput();
        }
        
        //Check approved and valid id
        $employeeData = DB::table('employees')
        ->select('employees.employee_id')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->where('employees.employee_id', '=', $request->employee_id)
        ->where('users.approved', '=', "1")
        ->first();


        //update salary
        if ($employeeData) {
            $employee = Employee::find($employeeData->employee_id);
            if ($employee) {
                $employee->salary = $request->salary;
                $employee->save();
            }
        }

        //Display Employee Page
        $employees = DB::table('employees')
        ->join('users', 'employees.user_id', '=', 'users.user_id')
        ->join('roles', 'users.role_id', '=', 'roles.role_id')
        ->where('users.approved', '=', '1')
        ->get();
        
        return view('employees', ['employees' => $employees])->with('level', session('level'));
    }
}
