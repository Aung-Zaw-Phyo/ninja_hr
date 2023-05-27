<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    
    public function taskData(Request $request) {
        $project = Project::with('tasks')->where('id', $request->project_id)->firstOrFail();
        return view('components.task_data', compact('project'))->render();
    }

    public function store (Request $request) {
        
        $task = new Task();
        $task->project_id = $request->project_id;
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->status = $request->status;
        $task->save();

        $task->members()->sync($request->members);

        return [
            'status' => 'success',
            'message' => 'Task Successfully Created.',
        ];
    }

    public function update (Request $request, $id) {
        $task = Task::findOrFail($id);
        $task->title = $request->title;
        $task->description = $request->description;
        $task->start_date = $request->start_date;
        $task->deadline = $request->deadline;
        $task->priority = $request->priority;
        $task->update();

        $task->members()->sync($request->members);

        return [
            'status' => 'success',
            'message' => 'Task Successfully Updated.',
        ];
    }

    public function destroy ($id) {
        $task = Task::findOrFail($id);
        $task->members()->detach();
        $task->delete();
        return [
            'status' => 'success',
            'message' => 'Task Successfully Deleted.',
        ];
    }

    public function taskSortable (Request $request) {
        $project = Project::with('tasks')->where('id', $request->project_id)->firstOrFail();

        if($request->pendingTaskBoard) {
            $pendingTaskBoard = explode(',', $request->pendingTaskBoard);
            foreach($pendingTaskBoard as $key => $task_id ) {
                $task = collect($project->tasks)->where('id', $task_id)->first();
                if($task) {
                    $task->status = 'pending';
                    $task->serial_number = $key;
                    $task->update();
                }
            }
        }

        if($request->inProgressTaskBoard) {
            $inProgressTaskBoard = explode(',', $request->inProgressTaskBoard);
            foreach($inProgressTaskBoard as $key => $task_id ) {
                $task = collect($project->tasks)->where('id', $task_id)->first();
                if($task) {
                    $task->status = 'in_progress';
                    $task->serial_number = $key;
                    $task->update();
                }
            }
        }

        if($request->completeTaskBoard) {
            $completeTaskBoard = explode(',', $request->completeTaskBoard);
            foreach($completeTaskBoard as $key => $task_id ) {
                $task = collect($project->tasks)->where('id', $task_id)->first();
                if($task) {
                    $task->status = 'complete';
                    $task->serial_number = $key;
                    $task->update();
                }
            }
        }

        return 'success';
    }

}
