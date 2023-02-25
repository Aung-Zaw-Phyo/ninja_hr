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
            <div class="card">
                <div class="card-body">
                    <h4 class="text-center">Login</h4>
                    <p class="text-muted text-center mb-4">Please fill the form to login.</p>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-outline mb-4">
                            <input id="phone" type='number' class="form-control form-control-lg @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autofocus>
                            <label class="form-label" for="phone">Phone Number</label>
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-outline mb-4">
                            <input id="password" type="password" class="form-control form-control-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <label class="form-label" for="password">Password</label>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-outline mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-lg btn-theme w-100">
                            {{ __('Login') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
