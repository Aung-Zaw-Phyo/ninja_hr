@extends('layouts.app')

@section('title', 'Edit Employee')

@section('content')
    <div>
        <form action="{{ route('employee.update', $employee->id) }}" autocomplete="off" id="edit-employee" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='employee_id' value="{{$employee->employee_id}}" id="employee_id" class="form-control form-control-lg" />
                                <label class="form-label" for="employee_id">Employee ID</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" name='name' value="{{$employee->name}}" id="name" class="form-control form-control-lg" />
                                <label class="form-label" for="name">Name</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" name='phone' value="{{$employee->phone}}" id="phone" class="form-control form-control-lg" />
                                <label class="form-label" for="phone">Phone</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="email" name='email' value="{{$employee->email}}" id="email" class="form-control form-control-lg" />
                                <label class="form-label" for="email">Email</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="text" name='nrc_number' value="{{$employee->nrc_number}}" id="nrc_number" class="form-control form-control-lg" />
                                <label class="form-label" for="nrc_number">NRC Number</label>
                            </div>
                            <div class=" mb-4">
                                <select type="text" id="gender" name="gender" class="form-select form-control-lg">
                                    <option value="male" @if ($employee->gender == 'male') selected @endif>Male</option>
                                    <option value="female" @if ($employee->gender == 'female') selected @endif>Female</option>
                                </select>
                            </div>
                            <div class="form-outline mb-4">
                                <input name='birthday' type="text" value="{{$employee->birthday}}" id="birthday" class="form-control form-control-lg birthday"/>
                                <label class="form-label" for="birthday">Birthday</label>
                            </div>
                            <div class=" mb-4">
                                <select type="text" name="department_id" id="department" class="form-select form-control-lg">
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" @if ($employee->department_id == $department->id) selected @endif>{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class=" mb-4">
                                <select type="text" name="roles[]" id="" class="form-select form-control-lg select-ninja" multiple>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}" @if(in_array($role->id, $old_roles)) selected @endif>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-outline mb-4">
                                <input name='date_of_join' type="text" value="{{$employee->date_of_join}}" id="date_of_join" class="form-control form-control-lg date_of_join" />
                                <label class="form-label" for="date_of_join">Date Of Join</label>
                            </div>
                            <div class=" mb-4">
                                <select type="text" name="is_present" id="is_present" class="form-select form-control-lg">
                                    <option value="1" @if ($employee->is_present == 1) selected @endif>Yes</option>
                                    <option value="0" @if ($employee->is_present == 0) selected @endif>No</option>
                                </select>
                            </div>
                            <div class="form-outline mb-4">
                                <textarea id="address" name='address' class="form-control form-control-lg" rows="3">{{$employee->address}}</textarea>
                                <label class="form-label" for="addreess">Address</label>
                            </div>
                            <div class=" mb-4">
                                <input class="form-control form-control-lg m-0" type="file" name="profile_img" id="profile_img" />
        
                                <div class="preview_img d-flex align-items-start">
                                    @if ($employee->profile_img)
                                        <img src="{{$employee->profile_img_path()}}" alt="">
                                    @endif
                                </div>
                            </div>
                            <div class="form-outline mb-4">
                                <input name='password' type="password" id="password" class="form-control form-control-lg password" />
                                <label class="form-label" for="password">password</label>
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

{!! JsValidator::formRequest('App\Http\Requests\UpdateEmployee', '#edit-employee') !!}
<script>
    $(document).ready(function () {

        $('.birthday').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "maxDate": moment(),
            "locale": {
                "format": "YYYY-MM-DD",
            }, 
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        $('.date_of_join').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "maxDate": moment(),
            "locale": {
                "format": "YYYY-MM-DD",
            }, 
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        $('#profile_img').on('change', function () {
            let profile_img_length = document.getElementById('profile_img').files.length
            $('.preview_img').html('')
            for (let i = 0; i < profile_img_length; i++) {
                $('.preview_img').append(`<img src="${URL.createObjectURL(event.target.files[i])}"/>`)                
            }
        })

    })
</script>
@endsection

