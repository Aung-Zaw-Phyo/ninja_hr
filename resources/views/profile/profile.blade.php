@extends('layouts.app')

@section('title', 'Employee Detail')

@section('content')

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center">
                        <div>
                            <img class="profile-img" src="{{$employee->profile_img_path()}}" alt="">
                        </div>
                        <div class="m-3">
                            <h4>{{$employee->name}}</h4>
                            <p class="mb-2 text-muted"><span>{{$employee->employee_id}}</span> | <span class="text-theme">{{ $employee->phone }}</span></p>
                            <p class="mb-2"><span class="badge badge-pill badge-light">{{$employee->department ? $employee->department->title : '-'}}</span></p>
                            <p class="mb-2">
                                @foreach ($employee->roles as $role)
                                    <span class="badge badge-pill badge-primary m-1">{{$role->name}}</span>
                                @endforeach
                            </p>
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

    <div class="card mb-3">
        <div class="card-body">
            
            <span class="biometric-data-container">

            </span>

            <button class="btn biometric-auth-btn" id="biometric-register-btn">
                <i class="fa-solid fa-fingerprint"></i>
                <p class="mb-0 mt-1">
                    <i class="fa-sharp fa-solid fa-circle-plus"></i>
                </p>
            </button>
        </div>
    </div>
    
    <div class="card mb-3">
        <div class="card-body">
            <a href="#" class="btn btn-theme btn-block logout-btn"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a>
        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            const getBiometricData = () => {
                $.ajax({
                    url: '/profile/biometric-data',
                    type: 'POST',
                    success: function(res){
                        $('.biometric-data-container').html(res);
                    },
                    error: function(res){
                        console.log(res);
                    }
                })
            }
            getBiometricData()

            // Registering credentials 
            const register = (event) => {
                event.preventDefault()
                $('#biometric-register-btn').attr('disabled', 'disabled');
                new Larapass({
                    register: 'webauthn/register',
                    registerOptions: 'webauthn/register/options'
                }).register()
                .then(response => {
                    Toast.fire({
                        icon: 'success',
                        title: 'Biometric data successfully created.'
                    })
                    getBiometricData()
                    $('#biometric-register-btn').removeAttr('disabled');
                })
                .catch(response => {
                    console.log(response)
                    $('#biometric-register-btn').removeAttr('disabled');
                })
            }

            document.getElementById('biometric-register-btn').addEventListener('click', register)


            $('.logout-btn').on('click', function (e) {
                e.preventDefault()
                swal({
                    text: "Are you sure you want to logout?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: '/logout',
                            type: 'POST',
                            dataType: 'json',
                            success: function(res){
                                window.location.reload()
                            },
                            error: function(res){
                                console.log(res)
                            }
                        })
                    } 
                });
                
            })

            $(document).on('click', '.biometric-delete-btn', function (event) {
                event.preventDefault()
                let id = $(this).data('id')
                swal({
                    text: "Are you sure you want to delete?",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: `/profile/biometric-data/delete/${id}`,
                            type: 'DELETE',
                            success: function(res){
                                getBiometricData()
                            },
                            error: function(res){
                                console.log(res)
                            }
                        })
                    } 
                });
            })
        })
    </script>
@endsection