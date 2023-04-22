@extends('layouts.app')

@section('title', 'Employees')

@section('content')
    <a href="{{ route('employee.create') }}" class="btn btn-theme"><i class="fas fa-plus-circle"></i> Create Employee</a>
    <div class="card mt-3">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered DataTable">
                    <thead>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Is Present ?</th>
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
            processing: true,
            responsive: true,
            serverSide: true,
            ajax: "employee/datatable/ssd",
            columns: [
                {data: 'employee_id', name: 'employee_id', class: 'text-center'},
                {data: 'name', name: 'name', class: 'text-center'},
                {data: 'email', name: 'email', class: 'text-center'},
                {data: 'phone', name: 'phone', class: 'text-center'},
                {data: 'department', name: 'department', class: 'text-center'},
                {data: 'is_present', name: 'is_present', class: 'text-center'},
                // {
                //     data: 'action',
                //     name: 'action',
                //     orderable: true,
                //     searchable: true
                // },
            ],

        });
        document.querySelector('.DataTable').classList.add('w-100 h-100');
    })
</script>
@endsection

