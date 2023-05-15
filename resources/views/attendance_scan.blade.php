@extends('layouts.app')

@section('title', 'Attendance Scan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <img width="260px" src="{{ asset('images/scan.png') }}" alt="">
                    <p class="mb-3 text-muted">Please Scan Attendance QR</p>
                    <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#scanModal">
                        Scan
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
  
<!-- Modal -->
<div class="modal fade" id="scanModal" tabindex="-1" aria-labelledby="scanModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="scanModalLabel">Scan Attendance QR</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <video width="100%" height="380px" id="video"></video>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script src="{{ asset('js/qr-scanner.umd.min.js') }}"></script>
    <script>

        $(document).ready(function () {
            let videoElem = document.getElementById('video')
            let myModalEl = document.getElementById('scanModal')
        
            const qrScanner = new QrScanner(
                videoElem,
                result => {
                    if(result){
                        $.ajax({
                            url: 'attendance-scan/store',
                            type: 'POST',
                            data: {'hash_value': result},
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
                            },
                            error: (res) => {
                                console.log(res)
                            }
                        })

                        qrScanner.stop();
                        let myModal = bootstrap.Modal.getOrCreateInstance(document.getElementById('scanModal'));
                        myModal.hide();
                    }
                },
            );
        
            myModalEl.addEventListener('show.bs.modal', function (event) {
                qrScanner.start();
            })
            myModalEl.addEventListener('hidden.bs.modal', function (event) {
                qrScanner.stop();
            })
        })
    
    </script>
@endsection
