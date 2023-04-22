<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Models\Department;

class EmployeeController extends Controller
{
    public function index () {
        return view('employee.index');
    }

    public function ssd () {
        $data = User::query();
            return Datatables::of($data)
            ->addColumn('department', function($each) {
                return $each->department ? $each->department->title : '-';
            })
            ->editColumn('is_present', function($each) {
                if($each->is_present == 1){
                    return "<span class='badge badge-pill badge-success'>Present</span>";
                }else {
                    return "<span class='badge badge-pill badge-danger'>Leave</span>";
                }
            })
            ->rawColumns(['is_present'])
            ->make(true);
    }

    public function create () {
        $departments = Department::get();
        return view('employee.create', compact('departments'));
    }

    public function store (StoreEmployee $request) {
        $employee = new User();
        $employee->employee_id = $request->employee_id;
        $employee->name = $request->name;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->nrc_number = $request->nrc_number;
        $employee->gender = $request->gender;
        $employee->birthday = $request->birthday;
        $employee->department_id = $request->department_id;
        $employee->date_of_join = $request->date_of_join;
        $employee->is_present = $request->is_present;
        $employee->address = $request->address;
        $employee->password = $request->password;
        $employee->save();

        return redirect()->route('employee.index')->with('create', 'Employee is successfully created.');
    }
}
