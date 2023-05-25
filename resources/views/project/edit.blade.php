@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div>
        <form action="{{ route('project.update', $project->id) }}" autocomplete="off" id="edit-project" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" name='title' id="title" class="form-control form-control-lg" value="{{ old('title', $project->title) }}"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="4">{{ old('description', $project->description) }}</textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="images" class="form-label">Images (Only PNG, JPG, JPEG)</label>
                                <input class="form-control form-control-lg m-0" type="file" name="images[]" id="images" multiple accept="image/.png,.jpg,.jpeg"/>
        
                                <div class="preview_img d-flex align-items-start">
                                    @if ($project->images)
                                        @foreach ($project->images as $image)
                                            <img src="{{ asset('storage/project/'.$image) }}" alt="">
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="files" class="form-label">Files (Only PDF)</label>
                                <input class="form-control form-control-lg m-0" type="file" name="files[]" id="files" multiple accept="application/pdf"/>
                                <div class="py-2">
                                    @if ($project->files)
                                        @foreach ($project->files as $file)
                                        <a href="{{ asset('storage/project/'.$file) }}" class="pdf-thumbnail" target="_blank">
                                            <i class="fa-solid fa-file-pdf"></i>
                                            <p>File {{ $loop->iteration }}</p>
                                        </a>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="start_date">Start Date</label>
                                <input name='start_date' type="text" id="start_date" class="form-control form-control-lg datepicker" value="{{ old('start_date', $project->start_date) }}"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="deadline">Deadline</label>
                                <input name='deadline' type="text" id="deadline" class="form-control form-control-lg datepicker" value="{{ old('deadline', $project->deadline) }}"/>
                            </div>
                            <div class="form-group mb-4">
                                <label for="leaders" class="form-label">Leaders</label>
                                <select name="leaders[]" id="leaders" class="form-select form-control-lg select-ninja" multiple>
                                    <option value="">---- Please Choose ----</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" @if(in_array($employee->id, collect($project->leaders)->pluck('id')->toArray())) selected @endif>{{ $employee->name }} ({{ $employee->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="members" class="form-label">Members</label>
                                <select name="members[]" id="members" class="form-select form-control-lg select-ninja" multiple>
                                    <option value="">---- Please Choose ----</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" @if(in_array($employee->id, collect($project->members)->pluck('id')->toArray())) selected @endif>{{ $employee->name }} ({{ $employee->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="priority" class="form-label">Priority</label>
                                <select name="priority" id="priority" class="form-select form-control-lg select-ninja">
                                    <option value="">---- Please Choose ----</option>
                                    <option value="high" @if($project->priority == 'high') selected @endif>High</option>
                                    <option value="middle" @if($project->priority == 'middle') selected @endif>Middle</option>
                                    <option value="low" @if($project->priority == 'low') selected @endif>Low</option>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select form-control-lg select-ninja">
                                    <option value="">---- Please Choose ----</option>
                                    <option value="pending" @if($project->status == 'pending') selected @endif>Pending</option>
                                    <option value="in_progress" @if($project->status == 'in_progress') selected @endif>In Progress</option>
                                    <option value="complete" @if($project->status == 'complete') selected @endif>Complete</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 mx-auto">
                            <button type="submit" class="btn btn-theme btn-block">CONFIRM</button>
                        </div>
                    </div>
                </div>
            </div>
            
            

        </form>
    </div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\UpdateProject', '#edit-project') !!}
<script>
    $(document).ready(function () {
        $('#images').on('change', function () {
            let profile_img_length = document.getElementById('images').files.length
            $('.preview_img').html('')
            for (let i = 0; i < profile_img_length; i++) {
                $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}"/>`)                
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
    })
</script>
@endsection

