<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-warning text-light">
                <h5 class="mb-0"><i class="fa-solid fa-list-check"></i> Pending</h5>
            </div>
            <div class="card-body alert rounded-0 alert-warning m-0">

                <div id="pendingTaskBoard">
                    @foreach (collect($project->tasks)->where('status', 'pending')->sortBy('serial_number') as $task)
                        <div class="task mb-2" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between mb-0">
                                <h6>{{ $task->title }}</h6>
                                <div class="task-action text-end">
                                    <a href="" class="task_edit_btn" data-task="{{ base64_encode(json_encode($task, JSON_HEX_APOS)) }}"  data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id'), JSON_HEX_APOS) ) }}"><i class="fas fa-edit text-warning"></i></a>
                                    <a href="" class="task_delete_btn" data-task="{{ base64_encode(json_encode($task, JSON_HEX_APOS)) }}"><i class="fas fa-trash text-danger"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <p class="mb-1"><i class="fa-regular fa-clock"></i> {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <p class="mb-1"><span class="badge badge-pill badge-danger">High</span></p>
                                    @elseif ($task->priority == 'middle')
                                        <p class="mb-1"><span class="badge badge-pill badge-info">Middle</span></p>
                                    @elseif ($task->priority == 'low')
                                        <p class="mb-1"><span class="badge badge-pill badge-dark">Low</span></p>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member )
                                        <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail3" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div>
                    <a href=""  class="add_pending_task_btn add_task_btn"><span><i class="fas fa-plus-circle text-dark"></i> Add Task</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-info text-light">
                <h5 class="mb-0"><i class="fa-solid fa-list-check"></i> In Progress</h5>
            </div>
            <div class="card-body alert rounded-0 alert-info m-0">
                
                <div id="inProgressTaskBoard">
                    @foreach (collect($project->tasks)->where('status', 'in_progress')->sortBy('serial_number') as $task)
                        <div class="task mb-2" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between mb-0">
                                <h6>{{ $task->title }}</h6>
                                <div class="task-action text-end">
                                    <a href="" class="task_edit_btn" data-task="{{ base64_encode(json_encode($task, JSON_HEX_APOS)) }}"  data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id'), JSON_HEX_APOS) ) }}"><i class="fas fa-edit text-warning"></i></a>
                                    <a href="" class="task_delete_btn" data-task="{{ base64_encode(json_encode($task, JSON_HEX_APOS)) }}"><i class="fas fa-trash text-danger"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <p class="mb-1"><i class="fa-regular fa-clock"></i> {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <p class="mb-1"><span class="badge badge-pill badge-danger">High</span></p>
                                    @elseif ($task->priority == 'middle')
                                        <p class="mb-1"><span class="badge badge-pill badge-info">Middle</span></p>
                                    @elseif ($task->priority == 'low')
                                        <p class="mb-1"><span class="badge badge-pill badge-dark">Low</span></p>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member )
                                        <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail3" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>
                    <a href=""  class="add_in_progress_task_btn add_task_btn"><span><i class="fas fa-plus-circle text-dark"></i> Add Task</span></a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-success text-light">
                <h5 class="mb-0"><i class="fa-solid fa-list-check"></i> Complete</h5>
            </div>
            <div class="card-body alert rounded-0 alert-success m-0">
                <div id="completeTaskBoard">
                    @foreach (collect($project->tasks)->where('status', 'complete')->sortBy('serial_number') as $task)
                        <div class="task mb-2" data-id="{{ $task->id }}">
                            <div class="d-flex justify-content-between mb-0">
                                <h6>{{ $task->title }}</h6>
                                <div class="task-action text-end">
                                    <a href="" class="task_edit_btn" data-task="{{ base64_encode(json_encode($task, JSON_HEX_APOS)) }}"  data-task-members="{{ base64_encode(json_encode(collect($task->members)->pluck('id'), JSON_HEX_APOS) ) }}"><i class="fas fa-edit text-warning"></i></a>
                                    <a href="" class="task_delete_btn" data-task="{{ base64_encode(json_encode($task, JSON_HEX_APOS)) }}"><i class="fas fa-trash text-danger"></i></a>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div>
                                    <p class="mb-1"><i class="fa-regular fa-clock"></i> {{ Carbon\Carbon::parse($task->deadline)->format('M d') }}</p>
                                    @if ($task->priority == 'high')
                                        <p class="mb-1"><span class="badge badge-pill badge-danger">High</span></p>
                                    @elseif ($task->priority == 'middle')
                                        <p class="mb-1"><span class="badge badge-pill badge-info">Middle</span></p>
                                    @elseif ($task->priority == 'low')
                                        <p class="mb-1"><span class="badge badge-pill badge-dark">Low</span></p>
                                    @endif
                                </div>
                                <div>
                                    @foreach ($task->members as $member )
                                        <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail3" alt="">
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div>
                    <a href=""  class="add_complete_task_btn add_task_btn"><span><i class="fas fa-plus-circle text-dark"></i> Add Task</span></a>
                </div>
            </div>
        </div>
    </div>
</div>