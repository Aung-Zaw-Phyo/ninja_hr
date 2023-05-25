@extends('layouts.app')

@section('title', 'Project')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="">
                <table class="table border table-bordered DataTable"  style="width:100%">
                    <thead>
                        <th class="no-sort no-search"></th>
                        <th>Title</th>
                        <th>Description</th>
                        <th class="no-sort">Leaders</th>
                        <th class="no-sort">Members</th>
                        <th>Start Date</th>
                        <th>Deadline</th>
                        <th>Priority</th>
                        <th>Status</th>
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
            ajax: "my-project/datatable/ssd",
            columns: [
                {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                {data: 'title', name: 'title', class: 'text-center'},
                {data: 'description', name: 'description', class: 'text-center'},
                {data: 'leaders', name: 'leaders', class: 'text-center'},
                {data: 'members', name: 'members', class: 'text-center'},
                {data: 'start_date', name: 'start_date', class: 'text-center'},
                {data: 'deadline', name: 'deadline', class: 'text-center'},
                {data: 'priority', name: 'priority', class: 'text-center'},
                {data: 'status', name: 'status', class: 'text-center'},
                {data: 'action', name: 'action', class: 'text-center'},
                {data: 'updated_at', name: 'updated_at', class: 'text-center'},
            ],
            order: [[10, 'desc']],
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
    })
</script>
@endsection

