@extends('layouts.app')

@section('title', 'Project Detail')
@section('extra_css')
    <style>
        /* .alert-warning{
            background-color: #fbf0da88;
        }
        .alert-info{
            background-color: #def1f788;
        }
        .alert-success{
            background-color: #d6f0e088;
        } */

        .select2-container {
            z-index: 9999 !important;
        }

        .select2-container--default .select2-selection--multiple {
            line-height: 28px !important;
            height: 42px !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            height: 60% !important;
            padding-left: 10px !important;
        }   

        .ghost {
            background-color: #eee;
            border: 2px dashed #333;
        }
 
        .sortable-chosen {
            background-color: #fff !important;
        }
    </style>   
@endsection

@section('content')
    <div>
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4>{{ $project->title }}</h4>
                        <p class="mb-4">
                            <p class="mb-1">
                                Start Date : <span class="text-muted">{{ $project->start_date }}</span> ,
                                Deadline : <span class="text-muted">{{ $project->deadline }}</span> 
                            </p>
                            <p class="mb-1">
                                Priority : 
                                @if ($project->priority == 'high')
                                    <span class="badge badge-pill badge-danger">High</span>
                                @elseif($project->priority == 'middle')
                                    <span class="badge badge-pill badge-info">Middle</span>
                                @elseif($project->priority == 'low')
                                    <span class="badge badge-pill badge-dark">Dark</span>
                                @endif
                                ,
                                Status : 
                                @if ($project->status == 'pending')
                                    <span class="badge badge-pill badge-warning">Pending</span>
                                @elseif($project->status == 'in_progress')
                                    <span class="badge badge-pill badge-primary">In Progress</span>
                                @elseif($project->status == 'complete')
                                    <span class="badge badge-pill badge-success">Complete</span>
                                @endif
                            </p>
                        </p>
                        <h5 class="">Description</h5>
                        <p class="mb-3">{{ $project->description }}</p>

                        <div class="row">
                            <div class="col-md-6">
                                @if ($project->leaders)
                                    <div class="mb-3">
                                        <h5>Leaders</h5>
                                        @foreach (($project->leaders ?? []) as $leader)
                                            <img src="{{ $leader->profile_img_path() }}" class="profile-thumbnail2"/>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if ($project->members)
                                    <div class="mb-3">
                                        <h5>Members</h5>
                                        @foreach (($project->members ?? []) as $member)
                                            <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail2"/>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-xl-3">
                @if ($project->images)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Images</h5>
                        <div id="images">
                            @foreach ($project->images as $image)
                                <img src="{{ asset('storage/project/'. $image) }}" class="image-thumbnail" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @if ($project->files)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Files</h5>
                        @foreach ($project->files as $file)
                            <a href="{{ asset('storage/project/'.$file) }}" class="pdf-thumbnail" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i>
                                <p>File {{ $loop->iteration }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5>Tasks</h5>
                        <div id="task_data">

                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\UpdateProject', '#edit-project') !!}
<!-- jsDelivr :: Sortable :: Latest (https://www.jsdelivr.com/package/npm/sortablejs) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
    $(document).ready(function () {
        new Viewer(document.getElementById('images'))
        
        const project_id = "{{ $project->id }}";
        const leaders = @json($project->leaders) ;
        const members = @json($project->members) ;

        
        const getTaskData = () => {
            $.ajax({
                url: `/task-data?project_id=${project_id}`,
                type: 'GET',
                success: (res) => {
                    $('#task_data').html(res)

                    const pendingTaskBoard = document.getElementById('pendingTaskBoard');
                    const completeTaskBoard = document.getElementById('completeTaskBoard');
                    const inProgressTaskBoard = document.getElementById('inProgressTaskBoard');

                    Sortable.create(pendingTaskBoard, {
                        group: "taskBoard", 
                        ghostClass: "ghost",
                        draggable: ".task",
                        chosenClass: "sortable-chosen",
                        swapThreshold: 2,
                        animation: 200,
                        store: {
                            set: function (sortable) {
                                let pendingTaskBoard = sortable.toArray();
                                localStorage.setItem('pendingTaskBoard', pendingTaskBoard.join(','));
                            }
                        },

                        onSort: function (evt) {
                            setTimeout(() => {
                                let pendingTaskBoard = localStorage.getItem('pendingTaskBoard')
                                console.log(pendingTaskBoard)
                                $.ajax({
                                    url: `/task-sortable?project_id=${project_id}&pendingTaskBoard=${pendingTaskBoard}`,
                                    type: 'GET',
                                    success: function (res) {
                                        console.log(res)
                                    }
                                })
                            }, 1000);
                        },
                    });

                    Sortable.create(inProgressTaskBoard, {
                        group: "taskBoard", 
                        ghostClass: "ghost",
                        draggable: ".task",
                        chosenClass: "sortable-chosen",
                        swapThreshold: 2,
                        animation: 200,
                        store: {
                            set: function (sortable) {
                                let inProgressTaskBoard = sortable.toArray();
                                localStorage.setItem('inProgressTaskBoard', inProgressTaskBoard.join(','));
                            }
                        },

                        onSort: function (evt) {
                            setTimeout(() => {
                                let inProgressTaskBoard = localStorage.getItem('inProgressTaskBoard')
                                console.log(inProgressTaskBoard)
                                $.ajax({
                                    url: `/task-sortable?project_id=${project_id}&inProgressTaskBoard=${inProgressTaskBoard}`,
                                    type: 'GET',
                                    success: function (res) {
                                        console.log(res)
                                    }
                                })
                            }, 1000);
                        },
                    });

                    Sortable.create(completeTaskBoard, {
                        group: "taskBoard", 
                        ghostClass: "ghost",
                        draggable: ".task",
                        chosenClass: "sortable-chosen",
                        swapThreshold: 2,
                        animation: 200,
                        store: {
                            set: function (sortable) {
                                let completeTaskBoard = sortable.toArray();
                                localStorage.setItem('completeTaskBoard', completeTaskBoard.join(','));
                            }
                        },

                        onSort: function (evt) {
                            setTimeout(() => {
                                let completeTaskBoard = localStorage.getItem('completeTaskBoard')
                                console.log(completeTaskBoard)
                                $.ajax({
                                    url: `/task-sortable?project_id=${project_id}&completeTaskBoard=${completeTaskBoard}`,
                                    type: 'GET',
                                    success: function (res) {
                                        console.log(res)
                                    }
                                })
                            }, 1000);
                        },
                    });

                },
                error: (res) => {
                    console.log(res)
                }
            })
        }
        
        getTaskData()
        
        let task_members_options = '';

        leaders.forEach((leader) => {
            task_members_options += `<option value="${leader.id}">${leader.name}</option>`
        })

        members.forEach((member) => {
            task_members_options += `<option value="${member.id}">${member.name}</option>`
        })

        // Create The Task

        $(document).on('click', '.add_pending_task_btn', (event) => {
            event.preventDefault()
            Swal.fire({
                title: 'Add Pending Task',
                html: `
                    <form id="pending_task_form">
                        <input type="hidden" name="project_id" value="${project_id}"/>
                        <input type="hidden" name="status" value="pending"/>
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter task title"/>
                        </div>
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter task description" rows="3"></textarea>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="start_date">Start Date</label>
                            <input name='start_date' type="text" id="start_date" class="form-control form-control-lg datepicker" />
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="deadline">Deadline</label>
                            <input name='deadline' type="text" id="deadline" class="form-control form-control-lg datepicker" />
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="members" class="form-label">Task Members</label>
                            <select name="members[]" id="members" class="form-select form-control-lg select-ninja" multiple>
                                <option value="">---- Please Choose ----</option>
                                ${task_members_options}
                            </select>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select name="priority" id="priority" class="form-select form-control-lg select-ninja">
                                <option value="">---- Please Choose ----</option>
                                <option value="high">high</option>
                                <option value="middle">middle</option>
                                <option value="low">low</option>
                            </select>
                        </div>
                    </form>
                `,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $('#pending_task_form').serialize();
                    $.ajax({
                        url: '/task',
                        type: 'POST',
                        data: formData,
                        success: (res) => {
                            if(res.status == 'success') {
                                getTaskData()
                            }else {
                                Toast.fire({
                                    icon: 'error',
                                    title: res.message
                                })
                            }
                        },
                        error: (res) => {
                            console.log(res)
                        }
                    })
                } 
            })

            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }, 
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

            $('.select-ninja').select2({
                placeholder: "Please choose",
                allowClear: true
            });
        })

        $(document).on('click', '.add_in_progress_task_btn', (event) => {
            event.preventDefault()
            Swal.fire({
                title: 'Add In Progress Task',
                html: `
                    <form id="in_progress_task_form">
                        <input type="hidden" name="project_id" value="${project_id}"/>
                        <input type="hidden" name="status" value="in_progress"/>
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter task title"/>
                        </div>
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter task description" rows="3"></textarea>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="start_date">Start Date</label>
                            <input name='start_date' type="text" id="start_date" class="form-control form-control-lg datepicker" />
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="deadline">Deadline</label>
                            <input name='deadline' type="text" id="deadline" class="form-control form-control-lg datepicker" />
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="members" class="form-label">Task Members</label>
                            <select name="members[]" id="members" class="form-select form-control-lg select-ninja" multiple>
                                <option value="">---- Please Choose ----</option>
                                ${task_members_options}
                            </select>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select name="priority" id="priority" class="form-select form-control-lg select-ninja">
                                <option value="">---- Please Choose ----</option>
                                <option value="high">high</option>
                                <option value="middle">middle</option>
                                <option value="low">low</option>
                            </select>
                        </div>
                    </form>
                `,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $('#in_progress_task_form').serialize();
                    $.ajax({
                    url: '/task',
                    type: 'POST',
                    data: formData,
                    success: (res) => {
                        if(res.status == 'success') {
                            getTaskData()
                        }else {
                            Toast.fire({
                                icon: 'error',
                                title: res.message
                            })
                        }
                    },
                    error: (res) => {
                        console.log(res)
                    }
                })
                } 
            })

            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }, 
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

            $('.select-ninja').select2({
                placeholder: "Please choose",
                allowClear: true
            });
        })

        $(document).on('click', '.add_complete_task_btn', (event) => {
            event.preventDefault()
            Swal.fire({
                title: 'Add Complete Task',
                html: `
                    <form id="complete_task_form">
                        <input type="hidden" name="project_id" value="${project_id}"/>
                        <input type="hidden" name="status" value="complete"/>
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter task title"/>
                        </div>
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter task description" rows="3"></textarea>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="start_date">Start Date</label>
                            <input name='start_date' type="text" id="start_date" class="form-control form-control-lg datepicker" />
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="deadline">Deadline</label>
                            <input name='deadline' type="text" id="deadline" class="form-control form-control-lg datepicker" />
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="members" class="form-label">Task Members</label>
                            <select name="members[]" id="members" class="form-select form-control-lg select-ninja" multiple>
                                <option value="">---- Please Choose ----</option>
                                ${task_members_options}
                            </select>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select name="priority" id="priority" class="form-select form-control-lg select-ninja">
                                <option value="">---- Please Choose ----</option>
                                <option value="high">high</option>
                                <option value="middle">middle</option>
                                <option value="low">low</option>
                            </select>
                        </div>
                    </form>
                `,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $('#complete_task_form').serialize();
                    $.ajax({
                    url: '/task',
                    type: 'POST',
                    data: formData,
                    success: (res) => {
                        if(res.status == 'success') {
                            getTaskData()
                        }else {
                            Toast.fire({
                                icon: 'error',
                                title: res.message
                            })
                        }
                    },
                    error: (res) => {
                        console.log(res)
                    }
                })
                } 
            })

            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }, 
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

            $('.select-ninja').select2({
                placeholder: "Please choose",
                allowClear: true
            });
        })

        // Edit The Task

        $(document).on('click', '.task_edit_btn', function (event) {
            event.preventDefault()
            const task = JSON.parse(atob($(this).data('task')));
            const task_members = JSON.parse(atob($(this).data('task-members')))
            let task_members_options = '';
            leaders.forEach((leader) => {
                task_members_options += `<option value="${leader.id}"  ${task_members.includes(leader.id) ? 'selected' : ''}>${leader.name}</option>`
            })

            members.forEach((member) => {
                task_members_options += `<option value="${member.id}"  ${task_members.includes(member.id) ? 'selected' : ''}>${member.name}</option>`
            })

            Swal.fire({
                title: 'Edit The Task',
                html: `
                    <form id="edit_task_form">
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" placeholder="Enter task title" value="${task.title}"/>
                        </div>
                        <div class="md-form text-start mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" placeholder="Enter task description" rows="3">${task.description}</textarea>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="start_date">Start Date</label>
                            <input name='start_date' type="text" id="start_date" class="form-control form-control-lg datepicker" value="${task.start_date}"/>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label class="form-label" for="deadline">Deadline</label>
                            <input name='deadline' type="text" id="deadline" class="form-control form-control-lg datepicker" value="${task.deadline}"/>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="members" class="form-label">Task Members</label>
                            <select name="members[]" id="members" class="form-select form-control-lg select-ninja" multiple>
                                <option value="">---- Please Choose ----</option>
                                ${task_members_options}
                            </select>
                        </div>
                        <div class="form-group text-start mb-3">
                            <label for="priority" class="form-label">Priority</label>
                            <select name="priority" id="priority" class="form-select form-control-lg select-ninja">
                                <option value="">---- Please Choose ----</option>
                                <option value="high" ${task.priority === 'high' ? 'selected' : ''}>High</option>
                                <option value="middle" ${task.priority === 'middle' ? 'selected' : ''}>Middle</option>
                                <option value="low" ${task.priority === 'low' ? 'selected' : ''}>Low</option>
                            </select>
                        </div>
                    </form>
                `,
                confirmButtonText: 'Confirm',
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = $('#edit_task_form').serialize();
                    $.ajax({
                        url: `/task/${task.id}`,
                        type: 'PUT',
                        data: formData,
                        success: (res) => {
                            if(res.status == 'success') {
                                getTaskData()
                            }else {
                                Toast.fire({
                                    icon: 'error',
                                    title: res.message
                                })
                            }
                        },
                        error: (res) => {
                            console.log(res)
                        }
                    })
                } 
            })

            $('.datepicker').daterangepicker({
                "singleDatePicker": true,
                "showDropdowns": true,
                "autoApply": true,
                "locale": {
                    "format": "YYYY-MM-DD",
                }, 
            }, function(start, end, label) {
                console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
            });

            $('.select-ninja').select2({
                placeholder: "Please choose",
                allowClear: true
            });
        })

        // Delete The Task

        $(document).on('click', '.task_delete_btn', function (e) { //This is parent to child selector to know latest render data in datatable.
            e.preventDefault()
            const task = JSON.parse(atob($(this).data('task')));
            swal({
                text: "Are you sure you want to delete?",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `/task/${task.id}`,
                        method: "DELETE"
                    }).done(function(res) {
                        if(res.status == 'success') {
                            getTaskData()
                        }else {
                            console.log(res)
                        }
                    });
                } 
            });

        })

    })
</script>
@endsection

