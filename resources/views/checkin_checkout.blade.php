@extends('layouts.app_plain')

@section('title', 'Checkin & Checkout')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center align-items-center " style="height: 100vh !important;">
        <div class="col-lg-6 ">
            <div class="card">
                <div class="card-body">
                    <div class="text-center my-3">
                        <h3 class="mb-3">QR</h3>
                        <img class="mb-3" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($hash_value)) !!} ">
                        <p class="text-muted">Please scan QR to check in or checkout</p>
                    </div>
                    <hr>
                    <div class="text-center my-3">
                        <h3 class="mb-3">Pin Code</h3>
                        <div class="mb-3">
                            <input type="text " name="mycode" id="pincode-input1">
                        </div>
                        <p class="text-muted">Please enter your pin code to check in or checkout</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function (){
            $('#pincode-input1').pincodeInput({inputs:6,complete:function(value, e, errorElement){
                console.log("code entered: " + value);
                
                $.ajax({
                    url: 'checkin-checkout/store',
                    type: 'POST',
                    data: {'pin_code': value},
                    success: (res) => {
                        if(res.status == 'success') {
                            Toast.fire({
                                icon: 'success',
                                title: res.message
                            })
                        }else {
                            Toast.fire({
                                icon: 'error',
                                title: res.message
                            })
                        }
                        $('.pincode-input-text').val('')
                        $('.pincode-input-text').first().focus()
                    },
                    error: (res) => {
                        console.log(res)
                    }
                })
                
                // $(errorElement).html("I'm sorry, but the code not correct");
            }});

            $('.pincode-input-text').first().focus()
        })
    </script>
@endsection
