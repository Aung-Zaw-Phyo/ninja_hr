@extends('layouts.app')

@section('title', 'Create Attendance')

@section('extra_css')
    <style>
        .invalid-feedback{
            margin-top: 40px !important;
        } 
    </style>
@endsection

@section('content')
    <div>
        <form action="{{ route('attendance.store') }}" autocomplete="off" id="create-attendance" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            @include('layouts.validate_error')
                            <div class="form-outline mb-4">
                                <label for="" class="form-label">Please choose employee</label>
                                <select type="text" name="user_id" id="employee_id" class="form-select form-control-lg select-ninja">
                                    <option value="" class="text-muted" >Please choose employee</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}" @if ($employee->id == old('user_id')) selected @endif>{{ $employee->employee_id }} ({{ $employee->name }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="date">Date</label>
                                <input name='date' type="text" id="date" class="form-control form-control-lg date" value="{{ old('date') }}"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="checkin_time">Check In Time</label>
                                <input type="text" name='checkin_time' id="checkin_time" class="form-control form-control-lg timepicker" value="{{ old('checkin_time') }}"/>
                            </div>
                            <div class="form-group mb-4">
                                <label class="form-label" for="checkout_time">Check Out Time</label>
                                <input type="text" name='checkout_time' id="checkout_time" class="form-control form-control-lg timepicker" value="{{ old('checkout_time') }}"/>
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

{!! JsValidator::formRequest('App\Http\Requests\StoreAttendance', '#create-attendance') !!}
<script>
    $(document).ready(function () {
        $('.date').daterangepicker({
            "singleDatePicker": true,
            "showDropdowns": true,
            "autoApply": true,
            "locale": {
                "format": "YYYY-MM-DD",
            }, 
        }, function(start, end, label) {
            console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
        });

        $('.timepicker').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "locale": {
                "format": "HH:mm:ss",
            }, 
        }).on('show.daterangepicker', function(ev, picker) {
            picker.container.find('.calendar-table').hide()
        });
    })
</script>
@endsection

