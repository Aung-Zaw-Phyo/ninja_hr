@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')
    <div>
        <form action="{{ route('permission.store') }}" autocomplete="off" id="create-permission" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <div class="form-outline mb-4">
                                <input type="text" name='name' id="name" class="form-control form-control-lg" />
                                <label class="form-label" for="name">Name</label>
                            </div>
                        </div>
                        <div class="col-lg-6 mx-auto">
                            <button type="submit" class="btn btn-theme btn-block">CONFIRM</button>
                        </div>
                    </div>
                </div>
            </div>
            
            

        </form>
    </div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\StorePermission', '#create-permission') !!}
<script>
    $(document).ready(function () {

    })
</script>
@endsection

