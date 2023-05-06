@extends('layouts.app')

@section('title', 'Department')

@section('content')
    @can('create_department')
        <a href="{{ route('department.create') }}" class="btn btn-theme"><i class="fas fa-plus-circle"></i> Create Employee</a>
    @endcan
    <div class="card mt-3">
        <div class="card-body">
            <div class="">
                <table class="table border table-bordered DataTable"  style="width:100%">
                    <thead>
                        <th class="no-sort no-search"></th>
                        <th>Title</th>
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
            ajax: "department/datatable/ssd",
            columns: [
                {data: 'plus-icon', name: 'plus-icon', class: 'text-center'},
                {data: 'title', name: 'title', class: 'text-center'},
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
            }

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
                        url: `/department/${id}`,
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

