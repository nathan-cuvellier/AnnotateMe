@extends('layouts.app')

@section('content')

    <p class="mt-5 p-0 text-center">
        Are you sure you want to delete the project :
        <strong>
            {{$project->name_prj}}
        </strong>
         ?
    </p>

    <div class="mt-5 mr-3">
        <div class="text-center">
            <form class="d-inline-block" method="POST" action="{{route('project.delete.post',['id'=>$project->id_prj]) }}">
                @csrf
                <input type="submit" class="mx-2 btn btn-danger" value="Delete project">
            </form>
            <a href="{{route('project.read',['id'=>$project->id_prj]) }}" class="mx-2 btn btn-primary">Cancel</a>
        </div>
    </div>



@endsection
