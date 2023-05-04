@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <a href="{{ route('employee.create') }}" class="btn btn-theme"><i class="fas fa-plus-circle"></i> Create Employee</a>
    <div class="card mt-3">
        <div class="card-body">
            <div class="">
                <table class="table border table-bordered DataTable"  style="width:100%">
                    <thead>
                        <th class="no-sort no-search"></th>
                        <th>Profile</th>
                        <th>Employee ID</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Is Present ?</th>
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
            responsive: true,
            processing: true,
            serverSide: true,
            ajax: "employee/datatable/ssd",
            columns: [
                {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                {data: 'profile_img', name: 'profile_img', class: 'text-center'},
                {data: 'employee_id', name: 'employee_id', class: 'text-center'},
                {data: 'email', name: 'email', class: 'text-center'},
                {data: 'phone', name: 'phone', class: 'text-center'},
                {data: 'department_name', name: 'department_name', class: 'text-center'},
                {data: 'is_present', name: 'is_present', class: 'text-center'},
                {data: 'action', name: 'action', class: 'text-center'},
                {data: 'updated_at', name: 'updated_at', class: 'text-center'},
            ],
            order: [[8, 'desc']],
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
        // document.querySelector('.DataTable').classList.add('w-100 h-100');

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
                        url: `/employee/${id}`,
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

