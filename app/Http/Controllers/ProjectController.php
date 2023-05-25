<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Http\Requests\StoreProject;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProject;
use App\Models\ProjectLeader;
use App\Models\ProjectMember;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index () {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }

        return view('project.index');
    }

    public function ssd () {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }

        $data = Project::with('leaders', 'members');
        return Datatables::of($data)
            ->addColumn('leaders', function ($each) {
                $output = '<div style="width: 170px">';
                foreach($each->leaders as $leader) {
                    $output .= '<img src="'. $leader->profile_img_path() .'" class="profile-thumbnail2"/>';
                }
                return $output . '</div>';
            })
            ->addColumn('members', function ($each) {
                $output = '<div style="width: 170px">';
                foreach($each->members as $member) {
                    $output .= '<img src="'. $member->profile_img_path() .'" class="profile-thumbnail2"/>';
                }
                return $output . '</div>';
            })
            ->editColumn('priority', function ($each) {
                if($each->priority == 'high'){
                    return '<span class="badge badge-pill badge-danger">High</span>';
                }else if($each->priority == 'middle'){
                    return '<span class="badge badge-pill badge-info">Middle</span>';
                }else {
                    return '<span class="badge badge-pill badge-Dark">Low</span>';
                }
            })
            ->editColumn('status', function ($each) {
                if($each->status == 'pending'){
                    return '<span class="badge badge-pill badge-warning">Pending</span>';
                }else if($each->status == 'in_progress'){
                    return '<span class="badge badge-pill badge-primary">In Progress</span>';
                }else {
                    return '<span class="badge badge-pill badge-success">Complete</span>';
                }
            })
            ->editColumn('description', function ($each) {
                return Str::limit($each->description, 120);
            })
            ->editColumn('updated_at', function($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('plus-icon', function($each){
                return null;
            })
            ->addColumn('action', function($each) {
                $info_icon = '';
                $edit_icon = '';
                $delete_icon = '';

                if (auth()->user()->can('view_project')) {
                    $info_icon = '<a href="'.route('project.show', $each->id).'" class="text-primary"><i class="fas fa-info-circle"></i></a>';
                }

                if (auth()->user()->can('edit_project')) {
                    $edit_icon = '<a href="'.route('project.edit', $each->id).'" class="text-warning"><i class="fas fa-edit"></i></a>';
                }

                if (auth()->user()->can('delete_project')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                }


                return '<div class="action-icon text-start">'.$info_icon.$edit_icon.$delete_icon.'</div>';
            })
            ->rawColumns(['leaders', 'members', 'priority', 'status', 'action'])
            ->make(true);
    }

    public function create () {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized Action');
        }

        $employees = User::Orderby('name')->get();

        return view('project.create', compact('employees'));
    }

    public function store (StoreProject $request) {
        if (!auth()->user()->can('create_project')) {
            abort(403, 'Unauthorized Action');
        }

        $images_name = null;
        if ($request->hasFile('images')) {
            $images_name = [];
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {
                $image_name = uniqid() . '_' . time() . '.' .$image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                $images_name[] = $image_name;
            }
        }

        $files_name = null;
        if ($request->hasFile('files')) {
            $files_name = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $file_name = uniqid() . '_' . time() . '.' .$file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                $files_name[] = $file_name;
            }
        }

        $project = new Project();
        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $images_name;
        $project->files = $files_name;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->save();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect()->route('project.index')->with('create', 'Project is successfully created.');
    }

    public function edit ($id) {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized Action');
        }

        $project = Project::findOrFail($id);
        $employees = User::orderBy('name')->get();
        return view('project.edit', compact('project', 'employees'));
    }

    public function update($id, UpdateProject $request) {
        if (!auth()->user()->can('edit_project')) {
            abort(403, 'Unauthorized Action');
        }

        $project = Project::findOrFail($id);

        $images_name = $project->images;
        if ($request->hasFile('images')) {
            $images_name = [];
            $images_file = $request->file('images');
            foreach ($images_file as $image_file) {
                $image_name = uniqid() . '_' . time() . '.' .$image_file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $image_name, file_get_contents($image_file));
                $images_name[] = $image_name;
            }
        }

        $files_name = $project->files;
        if ($request->hasFile('files')) {
            $files_name = [];
            $files = $request->file('files');
            foreach ($files as $file) {
                $file_name = uniqid() . '_' . time() . '.' .$file->getClientOriginalExtension();
                Storage::disk('public')->put('project/' . $file_name, file_get_contents($file));
                $files_name[] = $file_name;
            }
        }

        $project->title = $request->title;
        $project->description = $request->description;
        $project->images = $images_name;
        $project->files = $files_name;
        $project->start_date = $request->start_date;
        $project->deadline = $request->deadline;
        $project->priority = $request->priority;
        $project->status = $request->status;
        $project->update();

        $project->leaders()->sync($request->leaders);
        $project->members()->sync($request->members);

        return redirect()->route('project.index')->with('update', 'Project is successfully updated.');
    }

    public function show ($id) {
        if (!auth()->user()->can('view_project')) {
            abort(403, 'Unauthorized Action');
        }

        $project = Project::findOrFail($id);
        return view('project.show', compact('project'));
    }

    public function destroy ($id) {
        if (!auth()->user()->can('delete_project')) {
            abort(403, 'Unauthorized Action');
        }

        $project = Project::findOrFail($id);

        $leaders = ProjectLeader::where('project_id', $project->id)->get();
        foreach ($leaders as $leader) {
            $leader->delete();
        }

        $members = ProjectMember::where('project_id', $project->id)->get();
        foreach ($members as $member) {
            $member->delete();
        }

        $project->delete();
        return 'success';
    }
}
