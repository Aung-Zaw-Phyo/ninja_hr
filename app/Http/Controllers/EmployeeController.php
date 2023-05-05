<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEmployee;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index () {
        return view('employee.index');
    }

    public function ssd () {
        $data = User::with('department');
        return Datatables::of($data)
            ->filterColumn('department_name', function ($query, $keyword) {
                $query->whereHas('department', function ($q1) use($keyword){
                    $q1->where('title', 'like', '%'.$keyword.'%');
                }); 
            })
            ->editColumn('profile_img', function ($each) {
                if(!$each->profile_img_path()){
                    return '<p class="py-1">'.$each->name.'</p>';
                }
                return '<img class="profile-thumbnail" src="'.$each->profile_img_path().'"/><p class="py-1">'.$each->name.'</p>';
            })
            ->addColumn('department_name', function($each) {
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
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';

                return '<div class="action-icon text-start">'.$edit_icon.$info_icon.$delete_icon.'</div>';
            })
            ->rawColumns(['profile_img', 'is_present', 'action'])
            ->make(true);
    }

    public function create () {
        $departments = Department::get();
        return view('employee.create', compact('departments'));
    }

    public function store (StoreEmployee $request) {
        $profile_img_name = null;
        if ($request->hasFile('profile_img')) {
            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid() . '_' . time() . '.' .$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/' . $profile_img_name, file_get_contents($profile_img_file));
        }

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
        $employee->profile_img = $profile_img_name;
        $employee->password = $request->password;
        $employee->save();

        return redirect()->route('employee.index')->with('create', 'Employee is successfully created.');
    }

    public function edit ($id) {
        $employee = User::findOrFail($id);
        $departments = Department::orderBy('title')->get();
        return view('employee.edit', compact('employee', 'departments'));
    }

    public function update($id, UpdateEmployee $request) {
        $employee = User::findOrFail($id);

        $profile_img_name = $employee->profile_img;
        if ($request->hasFile('profile_img')) {
            Storage::disk('public')->delete('employee/'.$profile_img_name);

            $profile_img_file = $request->file('profile_img');
            $profile_img_name = uniqid() . '_' . time() . '.' .$profile_img_file->getClientOriginalExtension();
            Storage::disk('public')->put('employee/' . $profile_img_name, file_get_contents($profile_img_file));
        }

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
        $employee->profile_img = $profile_img_name;
        $employee->password = $request->password ? Hash::make($request->password) : $employee->password;
        $employee->update();

        return redirect()->route('employee.index')->with('update', 'Employee is successfully updated.');
    }

    
    public function show ($id) {
        $employee = User::findOrFail($id);
        return view('employee.show', compact('employee'));
    }

    public function destroy ($id) {
        $employee = User::findOrFail($id);
        $employee->delete();
        return 'success';
    }
}
