


@extends('layout.Projet')

@section('content')
	
	<style type="text/css">
		p{
			font-weight: bold;
			font-size: 1.1em;
		}
		span{ color: black; }
	</style>

	<!-- Check if the user connected -->
	@if (session()->get('typeExp') != NULL && session()->get('typeExp') == true)
		<a id="back_btn" href="{{url('/projects/')}}">❮ Back</a><br>

		<!-- Name of the project -->
		<h1>{{$project->name_prj}}</h1>

		<!-- Description of the project -->
		@if($project->desc_prj != NULL)
			<p><span>Description :</span> {{$project->desc_prj}}</p>
		@endif

		<!-- Limitation mode of the project ( and value ) -->
		@foreach($listeModes as $mode)
            @if ($project->id_mode == $mode->id_mode)
            	@if($project->id_mode == 1)
            		<p><span>Session limit :</span> {{$mode->label_mode}} ({{$project->limit_prj}} minutes)</p>
            	@else
            		<p><span>Session limit :</span> {{$mode->label_mode}} ({{$project->limit_prj}} annotations)</p>
            	@endif
            @endif
        @endforeach

        <!-- Annotation interface of the project -->
        @foreach($listeInterfaces as $interface)
            @if ($project->id_int == $interface->id_int)
                <p><span>Annotation interface :</span> {{$interface->label_int}}</p>
            @endif
        @endforeach
        
        <!-- Project update page button -->
        <form action="{{url('/projects\/')}}{{$project->id_prj}}/update">
			<input type="submit" class="myButton" value="Update"></input>
		</form>

		<!-- Start data annotation -->
		<h1 id="title_annotate" style="margin-bottom: 4vh;">Data to annotate</h1>
		<form action="{{url('/projects\/')}}{{$project->id_prj}}/annotation">
			<input type="submit" class="myButton" value="Start annotate"></input>
		</form>

	<!-- If the user isn't connected, access blocked and he's invited to log on -->
	@else
		<h1 style="color:red;">You are not connected</h1>
		<a id="back_btn" href="{{url('/')}}">❮ Log in</a><br>
	@endif
	
@endsection