@extends('layout.Projet')

@section('content')

	<style type="text/css">
		#delete_btn{ background-color: red; font-weight: normal; }
	</style>
	
	@if (session()->get('typeExp') != NULL && (session()->get('typeExp') == 'superadmin' || session()->get('typeExp') == 'admin'))
		<a id="back_btn" href="{{url('/projects/')}}">❮ Back</a>
		<br>
		<h1>{{$project[0]->name_prj}}</h1>

		@if($project[0]->desc_prj != NULL)
			<p>Description  : {{$project[0]->desc_prj}}</p>
		@endif

		<br><br>

		<h1 id="title_annotate" style="margin-bottom: 4vh;">Do you really want to delete this project ?</h1>

		<form action="{{url('/projects')}}">
			<input type="submit" class="myButton" value="Cancel"></input>
		</form>
		<br>
		<form action="{{url('/projects\/')}}{{$project[0]->id_prj}}/export">
			<input type="submit" class="myButton" value="Data export"></input>
		</form>
		<br>
		<form action="{{url('/projects\/')}}{{$project[0]->id_prj}}/delete-confirmed">
			<input type="submit" class="myButton" id="delete_btn" value="Delete project definitely"></input>
		</form>
	@else
		<h1 style="color:red;">You are not allowed to access this page</h1>
	@endif
	
@endsection