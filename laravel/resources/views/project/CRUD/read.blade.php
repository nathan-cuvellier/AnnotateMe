@extends('layouts.app')

@section('content')
    <div class="col-md-8 m-auto mt-5">
        @if(session('update'))
            <div class="alert alert-success" role="alert">
                {{ session('update') }}
            </div>
        @endif
        <p class="col-10 display-4 mt-5 p-0">@if(!$project->online_prj) [OFFLINE] @endif {{ str_replace('_', ' ', $project->name_prj) }}</p>
        <div>
            <div class="text-left">
                <div>
                    @if(empty($project->desc_prj))
                        <p class="font-italic">The project has no description...</p>
                    @else
                        <p>{!! nl2br($project->desc_prj) !!}</p>
                    @endif
                </div>
                <div>
                    @if($project->id_mode == 1)
                        <p>Duration : {{$project->limit_prj}}min</p>
                    @else
                        <p>Duration : {{$project->limit_prj}} annotation(s)</p>
                    @endif
                </div>
                <div>
                    <p>Annotation mode : {{$project->label_int}}</p>
                </div>
            </div>

        </div>
        <div class="row mr-3">

            <a @if($project->online_prj || $canAnnotate == false) href="{{route('project.annotate',['id'=>$project->id_prj]) }}" @endif class="@if(!$project->online_prj || $canAnnotate == false) disabled text-white @endif  mx-2 btn btn-primary">Start to
                annotate</a>
            @if(session('expert')['id'] == $project->id_exp || session('expert')['type'] == 'superadmin')
                <a href="{{route('project.update',['id'=>$project->id_prj]) }}" class="mx-2 btn btn-primary">Update
                    Project</a>
                <a href="{{route('project.export',['id'=>$project->id_prj]) }}" class="mx-2 btn btn-primary">Export data</a>
                <button type="button" class="mx-2 btn btn-danger" data-toggle="modal" data-target="#delete">
                    Delete project
                </button>
            @endif
        </div>
    </div>





    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        Are you sure you want to delete this project?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('project.delete',['id'=>$project->id_prj]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
