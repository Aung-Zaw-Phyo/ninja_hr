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
                    <h4 class="text-center">Login</h4>
                    <p class="text-muted text-center mb-4">Please fill the form to login.</p>

                    <form method="GET" action="{{ route('login-option') }}">

                        <div class="form-outline mb-4">
                            <input id="phone" type='number' class="form-control form-control-lg text-center mb-3 @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" placeholder="Enter phone number" autofocus>
                            @error('phone')
                                <p class="invalid-feedback text-center w-100" role="alert">
                                    <strong class="text-center">{{ $message }}</strong>
                                </p>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-lg btn-theme w-100 mt-3">
                            Continue
                        </button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
