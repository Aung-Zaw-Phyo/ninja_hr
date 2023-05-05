@extends('layouts.app')

@section('title', 'Create Department')

@section('content')
    <div>
        <form action="{{ route('department.store') }}" autocomplete="off" id="create-department" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-2">
                <div class="col-lg-12">
                    <div class="form-outline mb-4">
                        <input type="text" name='title' id="title" class="form-control form-control-lg" />
                        <label class="form-label" for="title">Title</label>
                    </div>
                </div>
                <div class="col-lg-6 mx-auto">
                    <button type="submit" class="btn btn-theme btn-block">CONFIRM</button>
                </div>
            </div>
            
            

        </form>
    </div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\StoreDepartment', '#create-department') !!}
<script>
    $(document).ready(function () {

    })
</script>
@endsection

