@extends('layouts.app')

@section('title', 'Attendance Scan')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-body text-center">
                    <img width="260px" src="{{ asset('images/scan.png') }}" alt="">
                    <p class="mb-3 text-muted">Please Scan Attendance QR</p>
                    <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#scanModal">
                        Scan
                    </button>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-lg-4 py-2">
                            <select name="" class="form-select form-control-lg select-month">
                                <option value="">------Please Choose (Month)------</option>
                                <option value="01" @if(now()->format('m') == '01') selected @endif>Jan</option>
                                <option value="02" @if(now()->format('m') == '02') selected @endif>Feb</option>
                                <option value="03" @if(now()->format('m') == '03') selected @endif>Mar</option>
                                <option value="04" @if(now()->format('m') == '04') selected @endif>Apr</option>
                                <option value="05" @if(now()->format('m') == '05') selected @endif>May</option>
                                <option value="06" @if(now()->format('m') == '06') selected @endif>Jun</option>
                                <option value="07" @if(now()->format('m') == '07') selected @endif>Jul</option>
                                <option value="08" @if(now()->format('m') == '08') selected @endif>Aug</option>
                                <option value="09" @if(now()->format('m') == '09') selected @endif>Sep</option>
                                <option value="10" @if(now()->format('m') == '10') selected @endif>Oct</option>
                                <option value="11" @if(now()->format('m') == '11') selected @endif>Nov</option>
                                <option value="12" @if(now()->format('m') == '12') selected @endif>Dec</option>
                            </select>
                        </div>
                        <div class="col-lg-4 py-2">
                            <select name="" class="form-select form-control-lg select-year">
                                <option value="">------Please Choose (Year)------</option>
                                @for ($i = 0; $i < 5; $i++)
                                    <option class="{{ now()->subYears($i)->format('Y') }}" @if(now()->format('Y') == now()->subYears($i)->format('Y')) selected @endif>
                                        {{ now()->subYears($i)->format('Y') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-lg-4 py-2">
                            <button class="btn btn-theme btn-block search-btn"><i class="fas fa-search"></i> SEARCH</button>
                        </div>
                    </div>

                    <h5 class="mb-4">Payroll</h5>

                    <div class="payroll_table mb-4">

                    </div>

                    <h5 class="mb-4">Attendance Overview</h5>

                    <div class="attendance_overview_table mb-4">

                    </div>


                    <h5 class="mb-4">Attendance records</h5>
                    <div class="mb-4">
                        <table class="table border table-bordered DataTable"  style="width:100%">
                            <thead>
                                <th class="no-sort no-search"></th>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Checkin Time</th>
                                <th>Checkout Time</th>
                            </thead>
                        </table>
                    </div>
        
        
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

            let table = $('.DataTable').DataTable({
                responsive: true,
                processing: true,
                serverSide: true,
                ajax: "my-attendance/datatable/ssd",
                columns: [
                    {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                    {data: 'employee_name', name: 'employee_name', class: 'text-center'},
                    {data: 'date', name: 'date', class: 'text-center'},
                    {data: 'checkin_time', name: 'checkin_time', class: 'text-center'},
                    {data: 'checkout_time', name: 'checkout_time', class: 'text-center'},
                ],
                order: [[2, 'desc']],
                columnDefs: [
                    {
                        targets: [0],
                        class: 'control'
                    },
                    {
                        targets: "no-sort",
                        sortable: false
                    },
                    {
                        targets: "no-search",
                        searchable: false
                    },
                    {
                        targets: "hidden",
                        visible: false
                    },
                    
                ],
                language: {
                    paginate: {
                        next: "<i class='fa-solid fa-circle-arrow-right'></i>",
                        previous: "<i class='fa-solid fa-circle-arrow-left'></i>"
                    },
                }

            });


            $('.select-month').select2({
                placeholder: "-------Please choose (Month)-------",
                allowClear: true
            });
            $('.select-year').select2({
                placeholder: "-------Please choose (Year)-------",
                allowClear: true
            });

            const attendanceOverview = () => {
                let month = $('.select-month').val();
                let year = $('.select-year').val()
                $.ajax({
                    url: `/my-attendance-overview-table?month=${month}&year=${year}`,
                    method: 'GET',
                    success: (res) => {
                        $('.attendance_overview_table').html(res)
                    }
                })

                table.ajax.url(`/my-attendance/datatable/ssd?month=${month}&year=${year}`).load(); // datatable request with new data
            }
            attendanceOverview()

            const payrollTable = () => {
                let month = $('.select-month').val();
                let year = $('.select-year').val()
                $.ajax({
                    url: `/my-payroll-table?&month=${month}&year=${year}`,
                    method: 'GET',
                    success: (res) => {
                        $('.payroll_table').html(res)
                    }
                })
            }
            payrollTable()

            $('.search-btn').on('click', (e) => {
                e.preventDefault()
                attendanceOverview()
                payrollTable()
            })

        })
    
    </script>
@endsection
