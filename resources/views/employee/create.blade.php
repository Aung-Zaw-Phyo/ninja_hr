@extends('layouts.app')

@section('title', 'Create Employee')
@section('extra_css')
    <style>
        .custom_margin {
            margin-bottom: 32px !important;
        }
    </style>
@endsection

@section('content')
    <div>
        <form action="{{ route('employee.store') }}" autocomplete="off" id="create-employee" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <div class="form-outline custom_margin">
                                <input type="text" name='employee_id' id="employee_id" class="form-control form-control-lg" />
                                <label class="form-label" for="employee_id">Employee ID</label>
                            </div>
                            <div class="form-outline custom_margin">
                                <input type="text" name='name' id="name" class="form-control form-control-lg" />
                                <label class="form-label" for="name">Name</label>
                            </div>
                            <div class="form-outline custom_margin">
                                <input type="text" name='phone' id="phone" class="form-control form-control-lg" />
                                <label class="form-label" for="phone">Phone</label>
                            </div>
                            <div class="form-outline custom_margin">
                                <input type="email" name='email' id="email" class="form-control form-control-lg" />
                                <label class="form-label" for="email">Email</label>
                            </div>
                            <div class="form-outline custom_margin">
                                <input type="text" name='nrc_number' id="nrc_number" class="form-control form-control-lg" />
                                <label class="form-label" for="nrc_number">NRC Number</label>
                            </div>
                            <div class=" custom_margin">
                                <select type="text" id="gender" name="gender" class="form-select form-control-lg gender">
                                    <option value=""></option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="form-outline custom_margin">
                                <input name='birthday' type="text" id="birthday" class="form-control form-control-lg birthday active "/>
                                <label class="form-label" for="birthday">Birthday</label>
                            </div>
                            <div class=" custom_margin">
                                <select type="text" name="department_id" id="department" class="form-select form-control-lg department-select">
                                    <option value=""></option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class=" custom_margin">
                                <select type="text" name="roles[]" id="" class="form-select form-control-lg roles_select" multiple>
                                    <option value=""></option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-outline custom_margin">
                                <input name='date_of_join' type="text" id="date_of_join" class="form-control form-control-lg date_of_join active " />
                                <label class="form-label" for="date_of_join">Date Of Join</label>
                            </div>
                            <div class=" custom_margin">
                                <select type="text" name="is_present" id="is_present" class="form-select form-control-lg is_present_select">
                                    <option value=""></option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                            <div class="form-outline custom_margin">
                                <textarea id="address" name='address' class="form-control form-control-lg py-2" rows="3"></textarea>
                                <label class="form-label" for="addreess">Address</label>
                            </div>
                            <div class=" custom_margin">
                                <input class="form-control form-control-lg m-0" type="file" name="profile_img" id="profile_img" />
        
                                <div class="preview_img d-flex align-items-start">
            
                                </div>
                            </div>
                            <div class="form-outline custom_margin">
                                <input name='pin_code' type="number" id="pin_code" class="form-control form-control-lg pin_code" />
                                <label class="form-label" for="pin_code">PIN Code</label>
                            </div>
                            <div class="form-outline custom_margin">
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

{!! JsValidator::formRequest('App\Http\Requests\StoreEmployee', '#create-employee') !!}
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

        $('.is_present_select').select2({
            placeholder: "Present Or Leave (Required)",
            allowClear: true
        });

        $('.roles_select').select2({
            placeholder: "Please choose roles (Required)",
            allowClear: true
        })

        $('.department-select').select2({
            placeholder: "Please choose department (Required)",
            allowClear: true
        })

        $('.gender').select2({
            placeholder: "Male or Female (Required)",
            allowClear: true
        })

    })
</script>
@endsection

