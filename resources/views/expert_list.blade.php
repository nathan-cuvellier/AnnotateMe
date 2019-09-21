@extends('layout.Projet')
<?php 

if (session()->get('typeExp') != NULL && (session()->get('typeExp') == "admin" || session()->get('typeExp') == "superadmin")) 
{
	echo "<a id='create_account' href=\"".url('register')."\">Create an account</a>";

	echo "<a id='create_project' class='MyButton' href=\"".url('newproject')."\">Create project</a>";

	echo "<a id='show_list_expert' class='MyButton' href=\"".url('list')."\">Show Expert's List</a>";
}

if (session()->get('typeExp') != NULL && session()->get('typeExp') == true)
{
	echo "<a id='deco' href=\"".url('logout')."\">Sign Out</a>";
}


?>
@section('content')

@if(session()->has('message'))
<p id="message"> {{session()->pull('message')}} </p> <!-- Get the message value and forget it -->
@endif

@if (session()->get('typeExp') != NULL && session()->get('typeExp') == true) 
<a id="back_btn" href="{{url('/projects/')}}">❮ Back</a><br>

<div style="margin-bottom:14%;">
	@foreach($allExpert as $aExp)

	<div id="{{$aExp->id_exp}}" class="all_show_expert">
		<!-- <div id="DelButton">X</div> -->
		@if(session()->get('typeExp') == 'superadmin')
		@if($aExp->type_exp == "expert" || $aExp->type_exp == "admin")
		<form method="post" action="{{url('/list\/')}}{{$aExp->id_exp}}/delete-expert">
			@csrf
			<button type="submit" class="myButton delete" id="delete_btn">X</button>
		</form>
		@endif
		@endif
		@if(session()->get('typeExp') == 'admin')
		@if($aExp->type_exp == "expert")
		<form method="post" action="{{url('/list\/')}}{{$aExp->id_exp}}/delete-expert">
			@csrf
			<button type="submit" class="myButton delete" id="delete_btn">X</button>
		</form>
		@endif
		@endif
		
		<div class="show_expert">
			{{$aExp->name_exp}} {{$aExp->firstname_exp}}
		</div>
		@if(session()->get('typeExp') == 'superadmin')
		@if($aExp->type_exp == "expert" || $aExp->type_exp == "admin")
		<div>
			<a class="modify" href="{{url('/list\/')}}{{$aExp->id_exp}}/update">Modify</a>
		</div>
		@else
		<div>SuperAdmin</div>
		@endif
		@elseif(session()->get('typeExp') == 'admin')
		@if($aExp->type_exp == "expert")
		<div><a href=""></a>Modify</div>
		@else
		<div>Admin</div>
		@endif
		@endif
	</div>

	@endforeach
</div>

<script>
	let all_show_expert = document.getElementsByClassName("all_show_expert");

	for(let one_expert of all_show_expert)
	{
		one_expert.addEventListener("click",function(){
		})
	}
</script>

@else
<h1 style="color:red;">You are not connected</h1>
<a id="back_btn" href="{{url('/')}}">❮ Log in</a><br>
@endif

@endsection