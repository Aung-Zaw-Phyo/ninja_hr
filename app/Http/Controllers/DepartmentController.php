<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Department;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use Yajra\DataTables\Facades\DataTables;

class DepartmentController extends Controller
{
    public function index () {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized Action');
        }

        return view('department.index');
    }

    public function ssd () {
        if (!auth()->user()->can('view_department')) {
            abort(403, 'Unauthorized Action');
        }

        $data = Department::query();
        return Datatables::of($data)
            ->editColumn('updated_at', function($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function($each){
                return null;
            })
            ->addColumn('action', function($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_department')) {
                    $edit_icon = '<a href="'.route('department.edit', $each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_department')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                }


                return '<div class="action-icon text-start">'.$edit_icon.$delete_icon.'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create () {
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized Action');
        }

        return view('department.create');
    }

    public function store (StoreDepartment $request) {
        if (!auth()->user()->can('create_department')) {
            abort(403, 'Unauthorized Action');
        }
        $department = new Department();
        $department->title = $request->title;
        $department->save();

        return redirect()->route('department.index')->with('create', 'Department is successfully created.');
    }

    public function edit ($id) {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }

        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));
    }

    public function update($id, UpdateDepartment $request) {
        if (!auth()->user()->can('edit_department')) {
            abort(403, 'Unauthorized Action');
        }

        $department = Department::findOrFail($id);

        $department->title = $request->title;
        $department->update();

        return redirect()->route('department.index')->with('update', 'Department is successfully updated.');
    }

    

    public function destroy ($id) {
        if (!auth()->user()->can('delete_department')) {
            abort(403, 'Unauthorized Action');
        }

        $department = Department::findOrFail($id);
        $department->delete();
        return 'success';
    }
}
