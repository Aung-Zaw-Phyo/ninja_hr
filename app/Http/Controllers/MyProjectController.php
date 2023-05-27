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

class MyProjectController extends Controller
{
    public function index () {
        return view('my_project');
    }

    public function ssd () {
        $data = Project::with('leaders', 'members')
        ->whereHas('leaders', function ($query)  {
            $query->where('user_id', auth()->user()->id);
        })
        ->orWhereHas('members', function ($query) {
            $query->where('user_id', auth()->user()->id);
        });
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

                $info_icon = '<a href="'.route('my-project.show', $each->id).'" class="text-primary"><i class="fas fa-info-circle"></i></a>';

                return '<div class="action-icon text-start">'.$info_icon.'</div>';
            })
            ->rawColumns(['leaders', 'members', 'priority', 'status', 'action'])
            ->make(true);
    }

    public function show ($id) {
        $project = Project::with('leaders', 'members', 'tasks')
            ->where('id', $id)
            ->where(function($query) {
                $query->whereHas('leaders', function ($q1)  {
                    $q1->where('user_id', auth()->user()->id);
                })
                ->orWhereHas('members', function ($q1) {
                    $q1->where('user_id', auth()->user()->id);
                });
            })
            ->firstOrFail();
        return view('my_project_show', compact('project'));
    }
}
