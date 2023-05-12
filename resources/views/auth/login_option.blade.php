@extends('layouts.app_plain')
@section('title', 'Ninja HR')
@section('extra_css')
    <style>
        
    </style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-md-8 col-lg-6">
            <div class="text-center mb-3">
                <img width="140" src="{{ asset('images/logo.png') }}" alt="NinjaHR Logo Image">
            </div>
            <div class="card" style="height: 40vh;">
                <div class="card-body">
                    <h4 class="text-center">Login Option</h4>
                    <p class="text-muted text-center mb-4">Please choose the login option.</p>

                    <!-- Pills navs -->
                    <ul class="nav nav-pills nav-justified mb-3" id="ex1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link active"
                                id="ex3-tab-password"
                                data-mdb-toggle="pill"
                                href="#ex3-pills-password"
                                role="tab"
                                aria-controls="ex3-pills-password"
                                aria-selected="true"
                            >
                                Password
                            </a>
                        </li>
                        
                        <li class="nav-item" role="presentation">
                            <a
                                class="nav-link"
                                id="ex3-tab-biometric"
                                data-mdb-toggle="pill"
                                href="#ex3-pills-biometric"
                                role="tab"
                                aria-controls="ex3-pills-biometric"
                                aria-selected="false"
                            >
                                Biometric
                            </a>
                        </li>
                    </ul>
                    <!-- Pills navs -->
                    
                    <!-- Pills content -->
                    <div class="tab-content" id="ex2-content">
                        <div
                            class="tab-pane fade show active"
                            id="ex3-pills-password"
                            role="tabpanel"
                            aria-labelledby="ex3-tab-password"
                        >
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger text-center alert-dismissible fade show" role="alert">
                                    {{ $error }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>                              
                            @endforeach
                            <form action="{{ route('login') }}" method="POST">
                                @csrf
                                <input type="hidden" name="phone" value="{{ request()->phone }}">
                                <div class="form-outline mb-4">
                                    <input id="password" type='password' class="form-control form-control-lg text-center mb-3 @error('password') is-invalid @enderror" name="password" autofocus placeholder="Enter password">
                                    {{-- @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror --}}
                                </div>
        
                                <button type="submit" class="btn btn-lg btn-theme w-100 mt-2">
                                    Confirm
                                </button>
                            </form>
                        </div>

                        <div
                            class="tab-pane fade"
                            id="ex3-pills-biometric"
                            role="tabpanel"
                            aria-labelledby="ex3-tab-biometric"
                        >
                            <input type="hidden" name="phone" value="{{ request()->phone }}" id="phone">
                            <div class="d-flex justify-content-center">
                                <button class="btn biometric-auth-btn" id="biometric-login-btn">
                                    <i class="fa-solid fa-fingerprint"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Pills content -->
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            const login = (event) => {
                event.preventDefault()
                new Larapass({
                    login: '/webauthn/login',
                    loginOptions: '/webauthn/login/options'
                })
                .login({
                    phone: document.getElementById('phone').value
                })
                .then(response => {
                    window.location.replace('/')
                })
                .catch(error => {
                    console.log(error)
                })
            }
            $('#biometric-login-btn').on('click', (event) => {
                login(event)
            })
        })
    </script>
@endsection
