@extends('layouts.app')

@section('title', 'Ninja HR')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="text-center">
                        <div>
                            <img class="profile-img" src="{{$employee->profile_img_path()}}" alt="">
                        </div>
                        <div class="m-3">
                            <h4>{{$employee->name}}</h4>
                            <p class="mb-2 text-muted"><span>{{$employee->employee_id}}</span> | <span class="text-theme">{{ $employee->phone }}</span></p>
                            <p class="mb-2"><span class="badge badge-pill badge-light">{{$employee->department ? $employee->department->title : '-'}}</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
