@extends('layouts.app')

@section('title', 'Create Employee')

@section('content')
    <div>
        <form action="{{ route('employee.store') }}" autocomplete="off" id="create-employee" method="POST">
            @csrf
            <div class="row g-2">
                <div class="col-lg-6">
                    <div class="form-outline mb-4">
                        <input type="text" name='employee_id' id="employee_id" class="form-control form-control-lg" />
                        <label class="form-label" for="employee_id">Employee ID</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" name='name' id="name" class="form-control form-control-lg" />
                        <label class="form-label" for="name">Name</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" name='phone' id="phone" class="form-control form-control-lg" />
                        <label class="form-label" for="phone">Phone</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="email" name='email' id="email" class="form-control form-control-lg" />
                        <label class="form-label" for="email">Email</label>
                    </div>
                    <div class="form-outline mb-4">
                        <input type="text" name='nrc_number' id="nrc_number" class="form-control form-control-lg" />
                        <label class="form-label" for="nrc_number">NRC Number</label>
                    </div>
                    <div class=" mb-4">
                        <select type="text" id="gender" name="gender" class="form-select form-control-lg">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>
                    <div class="form-outline mb-4">
                        <input name='birthday' type="text" id="birthday" class="form-control form-control-lg birthday"/>
                        <label class="form-label" for="birthday">Birthday</label>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class=" mb-4">
                        <select type="text" name="department_id" id="department" class="form-select form-control-lg">
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-outline mb-4">
                        <input name='date_of_join' type="text" id="date_of_join" class="form-control form-control-lg date_of_join" />
                        <label class="form-label" for="date_of_join">Date Of Join</label>
                    </div>
                    <div class=" mb-4">
                        <select type="text" name="is_present" id="is_present" class="form-select form-control-lg">
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
                    </div>
                    <div class="form-outline mb-4">
                        <textarea id="address" name='address' class="form-control form-control-lg" rows="3"></textarea>
                        <label class="form-label" for="addreess">Address</label>
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
            {{--  "autoUpdateInput": false,  --}}
            "locale": {
                "format": "YYYY-MM-DD",
            }, 
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        {{--  $('.birthday').on('apply.daterangepicker', function(ev, picker) {
            $('.birthday').val(picker.startDate.format('YYYY-MM-DD'));
        });  --}}
        {{--  $('.birthday').val('')  --}}


        $('.date_of_join').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "maxDate": moment(),
            {{--  "autoUpdateInput": false,  --}}
            "locale": {
                "format": "YYYY-MM-DD",
            }, 
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        {{--  setTimeout(()=> {
            console.log('hihihi')
            $('.birthday').removeAttr('autofocus')
        }, 3000)  --}}
    })
</script>
@endsection

