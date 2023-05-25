@extends('layouts.app')

@section('title', 'Project Detail')

@section('content')
    <div>
        <div class="row">
            <div class="col-lg-8 col-xl-9">
                <div class="card mb-3">
                    <div class="card-body">
                        <h4>{{ $project->title }}</h4>
                        <p class="mb-4">
                            <p class="mb-1">
                                Start Date : <span class="text-muted">{{ $project->start_date }}</span> ,
                                Deadline : <span class="text-muted">{{ $project->deadline }}</span> 
                            </p>
                            <p class="mb-1">
                                Priority : 
                                @if ($project->priority == 'high')
                                    <span class="badge badge-pill badge-danger">High</span>
                                @elseif($project->priority == 'middle')
                                    <span class="badge badge-pill badge-info">Middle</span>
                                @elseif($project->priority == 'low')
                                    <span class="badge badge-pill badge-dark">Dark</span>
                                @endif
                                ,
                                Status : 
                                @if ($project->status == 'pending')
                                    <span class="badge badge-pill badge-warning">Pending</span>
                                @elseif($project->status == 'in_progress')
                                    <span class="badge badge-pill badge-primary">In Progress</span>
                                @elseif($project->status == 'complete')
                                    <span class="badge badge-pill badge-success">Complete</span>
                                @endif
                            </p>
                        </p>
                        <h5 class="">Description</h5>
                        <p>{{ $project->description }}</p>
                    </div>
                </div>
                @if ($project->images)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Images</h5>
                        <div id="images">
                            @foreach ($project->images as $image)
                                <img src="{{ asset('storage/project/'. $image) }}" class="image-thumbnail" alt="">
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                @if ($project->files)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Files</h5>
                        @foreach ($project->files as $file)
                            <a href="{{ asset('storage/project/'.$file) }}" class="pdf-thumbnail" target="_blank">
                                <i class="fa-solid fa-file-pdf"></i>
                                <p>File {{ $loop->iteration }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4 col-xl-3">
                @if ($project->leaders)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>Leaders</h5>
                            @foreach (($project->leaders ?? []) as $leader)
                                <img src="{{ $leader->profile_img_path() }}" class="profile-thumbnail2"/>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if ($project->members)
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5>Members</h5>
                            @foreach (($project->members ?? []) as $member)
                                <img src="{{ $member->profile_img_path() }}" class="profile-thumbnail2"/>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')

{!! JsValidator::formRequest('App\Http\Requests\UpdateProject', '#edit-project') !!}
<script>
    $(document).ready(function () {
        new Viewer(document.getElementById('images'))
    })
</script>
@endsection

