<?php

namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use App\Models\Department;
use Carbon\Carbon;

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
            ->editColumn('updated_at', function($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function($each){
                return null;
            })
            ->addColumn('action', function($each) {
                $edit_icon = '<a href="'.route('employee.edit', $each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                $info_icon = '<a href="'.route('employee.show', $each->id).'" class="text-primary"><i class="fas fa-info-circle"></i></a>';
                return '<div class="action-icon text-start">'.$edit_icon.$info_icon.'</div>';
            })
            ->rawColumns(['is_present', 'action'])
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
