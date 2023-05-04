@extends('layouts.app')

@section('title', 'Employee Detail')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center">
                        <div>
                            <img class="profile-img" src="{{$employee->profile_img_path()}}" alt="">
                        </div>
                        <div class="ms-3">
                            <h5>{{$employee->name}}</h5>
                            <p class="mb-1">{{$employee->employee_id}}</p>
                            <p class="mb-1">{{$employee->department ? $employee->department->title : '-'}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 dash-border px-3">
                    <p><strong>Phone</strong> : <span>{{ $employee->phone }}</span></p>
                    <p><strong>Email</strong> : <span>{{ $employee->email }}</span></p>
                    <p><strong>NRC Number</strong> : <span>{{ $employee->nrc_number }}</span></p>
                    <p><strong>Gender</strong> : <span>{{ Str::ucfirst($employee->gender) }}</span></p>
                    <p><strong>Birthday</strong> : <span>{{ $employee->birthday }}</span></p>
                    <p><strong>Address</strong> : <span>{{ $employee->address }}</span></p>
                    <p><strong>Date Of Join</strong> : <span>{{ $employee->date_of_join }}</span></p>
                    <p>
                        <strong>Is Present?</strong> : 
                        @if ($employee->is_present == 1)
                            <span class="badge badge-pill badge-success">Present</span>
                        @else
                            <span class="badge badge-pill badge-warning">Leave</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

@endsection