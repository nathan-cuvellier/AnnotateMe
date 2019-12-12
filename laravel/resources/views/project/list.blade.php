@extends('layouts.app')

@section('content')
    @if(isset($noProjectFound))
        <div class="alert alert-warning w-50 mx-auto" role="alert">
            <p class="text-center m-0"><b>{{ $noProjectFound }}</b></p>
        </div>
    @else
        @includeWhen(!isset($noProjectFound), 'project.showList')
    @endif
@endsection
