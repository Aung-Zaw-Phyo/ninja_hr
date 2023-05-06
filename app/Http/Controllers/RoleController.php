<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Department;
use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index () {
        if (!auth()->user()->can('view_role')) {
            abort(403, 'Unauthorized Action');
        }

        return view('role.index');
    }

    public function ssd () {
        if (!auth()->user()->can('view_role')) {
            abort(403, 'Unauthorized Action');
        }

        $data = Role::query();
        return Datatables::of($data)
            ->editColumn('updated_at', function($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function($each){
                return null;
            })
            ->addColumn('permissions', function($each){
                $output = '';
                foreach($each->permissions as $permission){
                    $output .= '<span class="badge badge-pill badge-primary m-1">'. $permission->name .'</span>';
                }
                return $output;
            })
            ->addColumn('action', function($each) {
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('edit_role')) {
                    $edit_icon = '<a href="'.route('role.edit', $each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_role')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                }


                return '<div class="action-icon text-start">'.$edit_icon.$delete_icon.'</div>';
            })
            ->rawColumns(['permissions', 'action'])
            ->make(true);
    }

    public function create () {
        if (!auth()->user()->can('create_role')) {
            abort(403, 'Unauthorized Action');
        }

        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store (StoreRole $request) {
        if (!auth()->user()->can('create_role')) {
            abort(403, 'Unauthorized Action');
        }

        $role = new Role();
        $role->name = $request->name;
        $role->save();

        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index')->with('create', 'Role is successfully created.');
    }

    public function edit ($id) {
        if (!auth()->user()->can('edit_role')) {
            abort(403, 'Unauthorized Action');
        }

        $role = Role::findOrFail($id);
        $permissions = Permission::all();
        $old_permissions = $role->permissions()->pluck('id')->toArray();
        return view('role.edit', compact('role', 'permissions', 'old_permissions'));
    }

    public function update($id, UpdateRole $request) {
        if (!auth()->user()->can('edit_role')) {
            abort(403, 'Unauthorized Action');
        }

        $role = Role::findOrFail($id);
        $role->name = $request->name;
        $role->update();

        $role->syncPermissions($request->permissions);

        return redirect()->route('role.index')->with('update', 'Role is successfully updated.');
    }

    

    public function destroy ($id) {
        if (!auth()->user()->can('delete_role')) {
            abort(403, 'Unauthorized Action');
        }

        $role = Role::findOrFail($id);
        $role->delete();
        return 'success';
    }
}
