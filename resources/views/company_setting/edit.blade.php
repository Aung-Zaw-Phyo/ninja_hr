@extends('layouts.app')

@section('title', 'Edit Company Setting')

@section('content')
    <div>
        <form action="{{ route('company-setting.update', $setting->id) }}" autocomplete="off" id="edit-company_setting" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='company_name' value="{{$setting->company_name}}" id="company_name" class="form-control form-control-lg" />
                                <label class="form-label" for="company_name">Company Name</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='company_email' value="{{$setting->company_email}}" id="company_email" class="form-control form-control-lg" />
                                <label class="form-label" for="company_email">Company Email</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='company_phone' value="{{$setting->company_phone}}" id="company_phone" class="form-control form-control-lg" />
                                <label class="form-label" for="company_phone">Company Phone</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <textarea class="form-control" name="company_address" id="company_address" >{{$setting->company_address}}</textarea>
                                <label class="form-label" for="company_address">Company Address</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='office_start_time' value="{{$setting->office_start_time}}" id="office_start_time" class="form-control form-control-lg timepicker" />
                                <label class="form-label" for="office_start_time">Office Start Time</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='office_end_time' value="{{$setting->office_end_time}}" id="office_end_time" class="form-control form-control-lg timepicker" />
                                <label class="form-label" for="office_end_time">Office End Time</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='break_start_time' value="{{$setting->break_start_time}}" id="break_start_time" class="form-control form-control-lg timepicker" />
                                <label class="form-label" for="break_start_time">Break Start Time</label>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-outline mb-4">
                                <input type="text" name='break_end_time' value="{{$setting->break_end_time}}" id="break_end_time" class="form-control form-control-lg timepicker" />
                                <label class="form-label" for="break_end_time">Break End Time</label>
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

{!! JsValidator::formRequest('App\Http\Requests\UpdateCompanySetting', '#edit-employee') !!}
<script>
    $(document).ready(function () {

        $('.timepicker').daterangepicker({
            "singleDatePicker": true,
            "timePicker": true,
            "timePicker24Hour": true,
            "timePickerSeconds": true,
            "locale": {
                "format": "HH:mm:ss",
            }, 
        }).on('show.daterangepicker', function(ev, picker) {
            $('.calendar-table').hide()
        });
    })
</script>
@endsection

