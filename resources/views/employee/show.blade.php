@extends('layouts.app')

@section('title', 'Employee Detail')

@section('content')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Employee ID</p>
                        <p class="mb-0 text-muted">{{$employee->employee_id}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Name</p>
                        <p class="mb-0 text-muted">{{$employee->name}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Email</p>
                        <p class="mb-0 text-muted">{{$employee->email}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Phone</p>
                        <p class="mb-0 text-muted">{{$employee->phone}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> NRC Number</p>
                        <p class="mb-0 text-muted">{{$employee->nrc_number}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Gender</p>
                        <p class="mb-0 text-muted">{{ucfirst($employee->gender)}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Birthday</p>
                        <p class="mb-0 text-muted">{{$employee->birthday}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Address</p>
                        <p class="mb-0 text-muted">{{$employee->address}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Department</p>
                        <p class="mb-0 text-muted">{{$employee->department ? $employee->department->title : '-'}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Date Of Join</p>
                        <p class="mb-0 text-muted">{{$employee->date_of_join}}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="mb-3">
                        <p class="mb-0"><i class="fa-brands fa-gg"></i> Is Present ?</p>
                        @if ($employee->is_present == 1)
                            <span class="badge badge-pill badge-success">Present</span>
                        @else
                            <span class="badge badge-pill badge-warning">Leave</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection