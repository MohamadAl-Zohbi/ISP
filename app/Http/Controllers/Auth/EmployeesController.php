<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Employees;

class EmployeesController extends Controller
{
    public function login(Request $request)
    {
        $employee = Employees::where('username', $request->input('username'))->first();
        if ($employee) {
            if ($employee->password == $request->input('password')) {
                $token = $employee->createToken('auth_token');
                return response()->json(['status' => true, 'details' => $employee, 'token' => $token->plainTextToken]);
            } else {
                return response()->json(['status' => false, 'details' => 'wrond password']);
            }
        } else {
            return response()->json(['status' => false, 'details' => 'undefined user']);
        }
    }

    public function create_employee(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => 'no permession']);
        }

        $new_employee = Employees::create(
            [
                'name' => $request->input('name'),
                'password' => $request->input('password'),
                'username' => $request->input('username'),
                'rank' => $request->input('rank'),
                'is_frozen' => $request->input('is_frozen'),
            ]
        );
        return $new_employee;
    }

    public function update_employee(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => 'no permession']);
        }

        $employee = Employees::where('id', $id)->first();
        if ($employee) {
            $employee->name = $request->input('name');
            $employee->password = $request->input('password');
            $employee->username = $request->input('username');
            $employee->rank = $request->input('rank');
            $employee->is_frozen = $request->input('is_frozen');
            $employee->save();
            return response()->json(['status' => true, 'details' => $employee]);
        }
    }

    public function delete_employee(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $employee = Employees::where('id', $id);
        if ($employee) {
            $employee->delete();
            // $employee->save();
            return response()->json(['status' => true, 'details' => $employee]);
        }
    }

    public function show_all(Request $request)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $employees = Employees::all();
        if ($employees) {
            return response()->json(['status' => true, 'details' => $employees]);
        }
    }

    public function show(Request $request, $id)
    {
        $emp = $request->user();
        if ($emp->rank != 'super') {
            return response()->json(['status' => false, 'details' => 'no permission']);
        }

        $employee = Employees::find($id);
        if ($employee) {
            return response()->json(['status' => true, 'details' => $employee]);
        }
        return response()->json(['status' => false, 'details' => 'no user found']);
    }

    public function check(Request $request)
    {
        $emp = $request->user();
        if ($emp->is_frozen == false) {
            return response()->json(['status' => false]);
        }
        return response()->json(['status' => true]);
    }
}
