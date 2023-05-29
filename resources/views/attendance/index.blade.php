@extends('layouts.app')

@section('title', 'Attendance')
@section('extra_css')
    <style>
        .button-page-length, .button-page-length.active{
            background: #4CD195 !important;
            color: #fff !important;
            border: none !important;
            border-radius: 3px !important;
            outline: none !important;
        }
    </style>
@endsection
@section('content')
    @can('create_attendance')
        <a href="{{ route('attendance.create') }}" class="btn btn-theme"><i class="fas fa-plus-circle"></i> Create Attendance</a>
    @endcan
    <div class="card mt-3">
        <div class="card-body">
            <div class="">
                <table class="table border table-bordered DataTable"  style="width:100%">
                    <thead>
                        <th class="no-sort no-search"></th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Checkin Time</th>
                        <th>Checkout Time</th>
                        <th class="no-sort">Action</th>
                        <th class="hidden no-search ">Updated At</th>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function () {
        var table = $('.DataTable').DataTable({
            dom: 'Bfrtip',
            buttons: [
                {
                    extend: 'pdfHtml5',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    className: 'btn btn-dark',
                    orientation: 'portrait',
                    pageSize: 'A4',
                    title: 'Attendance',
                    exportOptions: {
                        columns: [ 1, 2, 3, 4]
                    },
                    customize: function (doc) {
                        doc.content.splice(0,1);
                        var now = new Date();
                        var datetime = now.getDate() + "/"
                                        + (now.getMonth()+1)  + "/" 
                                        + now.getFullYear() + " "  
                                        + now.getHours() + ":"  
                                        + now.getMinutes() + ":" 
                                        + now.getSeconds();
                        doc.pageMargins = [20,40,20,30];
                        doc.defaultStyle.fontSize = 8;
                        doc.styles.tableHeader.fontSize = 8;
                        doc.styles.tableBodyEven.alignment = 'center';
                        doc.styles.tableBodyOdd.alignment = 'center';

                        doc['header']=(function() {
                            return {
                                columns: [

                                    {
                                        alignment: 'left',
                                        italics: true,
                                        text: 'Attendance',
                                        fontSize: 12,
                                    },
                                    {
                                        alignment: 'right',
                                        fontSize: 10,
                                        text: `Export Time : ` + datetime,
                                    }
                                ],
                                margin: 20
                            }
                        });

                        doc['footer']=(function(page, pages) {
                            return {
                                columns: [
                                    {
                                        alignment: 'left',
                                        text: '',
                                    },
                                    {
                                        alignment: 'right',
                                        text: ['page ', { text: page.toString() },  ' of ', { text: pages.toString() }],
                                    }
                                ],
                                margin: [20,0,20,10]
                            }
                        });

                        var objLayout = {};
                        objLayout['hLineWidth'] = function(i) { return .5; };
                        objLayout['vLineWidth'] = function(i) { return .5; };
                        objLayout['hLineColor'] = function(i) { return '#aaa'; };
                        objLayout['vLineColor'] = function(i) { return '#aaa'; };
                        objLayout['paddingLeft'] = function(i) { return 4; };
                        objLayout['paddingRight'] = function(i) { return 4; };
                        doc.content[0].layout = objLayout;
                        doc.content[0].table.widths = ['20%', '20%', '30%', '30%']
                    }
                }, 
                {
                    text: "<i class='fas fa-sync'></i> Refresh",
                    className: 'btn btn-dark mx-1',
                    action: function (e, dt, node, config) {
                        dt.ajax.reload(null, false);
                    }
                },
                {
                    extend: 'pageLength',
                    className: 'btn btn-dark',
                },
            ],
            lengthMenu: [
                [10, 25, 50, 100, 500],
                ['10 rows', '25 rows', '50 rows', '100 rows', '500 rows'],
            ],
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "attendance/datatable/ssd",
            columns: [
                {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                {data: 'employee_name', name: 'employee_name', class: 'text-center'},
                {data: 'date', name: 'date', class: 'text-center'},
                {data: 'checkin_time', name: 'checkin_time', class: 'text-center'},
                {data: 'checkout_time', name: 'checkout_time', class: 'text-center'},
                {data: 'action', name: 'action', class: 'text-center'},
                {data: 'updated_at', name: 'updated_at', class: 'text-center'},
            ],
            order: [[3, 'desc']],
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
            },
        });

        $(document).on('click', '.delete-btn', function (e) { //This is parent to child selector to know latest render data in datatable.
            e.preventDefault()
            let id = $(this).data('id');
            swal({
                text: "Are you sure you want to delete?",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url: `/attendance/${id}`,
                        method: "DELETE"
                    }).done(function(res) {
                        if(res == 'success') {
                            table.ajax.reload()
                        }else {
                            console.log('fail')
                        }
                    });
                } 
            });

        })
    })
</script>
@endsection

