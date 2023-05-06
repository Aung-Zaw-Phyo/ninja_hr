@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
    <div>
        <form action="{{ route('role.store') }}" autocomplete="off" id="create-role" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card">
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-lg-12">
                            <div class="form-outline mb-4">
                                <input type="text" name='name' id="name" class="form-control form-control-lg" />
                                <label class="form-label" for="name">Name</label>
                            </div>
                            <label for="" class="mb-3">Permissions</label>
                            <div class="row g-2">
                                @foreach ($permissions as $permission)
                                <div class="col-lg-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $permission->name }}" id="checkbox_{{ $permission->id }}" />
                                        <label class="form-check-label" for="checkbox_{{ $permission->id }}">{{ $permission->name }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-lg-6 mx-auto mt-3">
                            <button type="submit" class="btn btn-theme btn-block">CONFIRM</button>
                        </div>
                    </div>
                </div>
            </div>
            
            

        </form>
    </div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\StoreRole', '#create-role') !!}
<script>
    $(document).ready(function () {

    })
</script>
@endsection

