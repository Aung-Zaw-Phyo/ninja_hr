@extends('layouts.app')

@section('title', 'Create Project')

@section('extra_css')
    <style>
        #status-error, #priority-error, #deadline-error, #start_date-error {
            margin-top: 45px !important;
        }
    </style>
@endsection

@section('content')
    <div>
        <form action="{{ route('project.store') }}" autocomplete="off" id="create-project" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <div class="form-group mb-4">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" name='title' id="title" class="form-control form-control-lg" />
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="description">Description</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="4"></textarea>
                            </div>
                            <div class="form-group mb-4">
                                <label for="images" class="form-label">Images (Only PNG, JPG, JPEG)</label>
                                <input class="form-control form-control-lg m-0" type="file" name="images[]" id="images" multiple accept="image/.png,.jpg,.jpeg"/>
        
                                <div class="preview_img d-flex align-items-start">
            
                                </div>
                            </div>
                            <div class="form-group mb-4">
                                <label for="files" class="form-label">Files (Only PDF)</label>
                                <input class="form-control form-control-lg m-0" type="file" name="files[]" id="files" multiple accept="application/pdf"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="start_date">Start Date</label>
                                <input name='start_date' type="text" id="start_date" class="form-control form-control-lg datepicker" />
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="deadline">Deadline</label>
                                <input name='deadline' type="text" id="deadline" class="form-control form-control-lg datepicker" />
                            </div>
                            <div class="form-group mb-4">
                                <label for="leaders" class="form-label">Leaders</label>
                                <select name="leaders[]" id="leaders" class="form-select form-control-lg select-ninja" multiple>
                                    <option value="">---- Please Choose ----</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="members" class="form-label">Members</label>
                                <select name="members[]" id="members" class="form-select form-control-lg select-ninja" multiple>
                                    <option value="">---- Please Choose ----</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_id }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="priority" class="form-label">Priority</label>
                                <select name="priority" id="priority" class="form-select form-control-lg select-ninja">
                                    <option value="">---- Please Choose ----</option>
                                    <option value="high">high</option>
                                    <option value="middle">middle</option>
                                    <option value="low">low</option>
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-select form-control-lg select-ninja">
                                    <option value="">---- Please Choose ----</option>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="complete">Complete</option>
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

{!! JsValidator::formRequest('App\Http\Requests\StoreProject', '#create-project') !!}
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

