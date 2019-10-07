@extends('layout.Projet')
<?php 

if (session()->get('typeExp') != NULL && (session()->get('typeExp') == "admin" || session()->get('typeExp') == "superadmin")) 
{
	echo "<a id='create_account' href=\"".url(route('account_register'))."\">Create an account</a>";

	echo "<a id='create_project' class='MyButton' href=\"".url(route('projects_new'))."\">Create project</a>";

	echo "<a id='show_list_expert' class='MyButton' href=\"".url(route('account_experts_list'))."\">Show Expert's List</a>";
}

if (session()->get('typeExp') != NULL && session()->get('typeExp') == true)
{
	echo "<a id='deco' href=\"".url(route('account_logout'))."\">Sign Out</a>";
}


?>
@section('content')

@if(session()->has('message'))
<p id="message"> {{session()->pull('message')}} </p> <!-- Get the message value and forget it -->
@endif

@if (session()->get('typeExp') != NULL && session()->get('typeExp') == true) 
<a id="back_btn" href="{{url(route('projects_list'))}}">❮ Back</a><br>

<div style="margin-bottom:14%;">
	@foreach($allExpert as $aExp)

	<div id="{{$aExp->id_exp}}" class="all_show_expert">
		<!-- <div id="DelButton">X</div> -->
		@if(session()->get('typeExp') == 'superadmin')
		@if($aExp->type_exp == "expert" || $aExp->type_exp == "admin")
		<form method="post" action="{{url(route('account_experts_expert_delete',['id_exp' => $aExp]))}}">
			@csrf
			<button type="submit" class="myButton delete" id="delete_btn">X</button>
		</form>
		@endif
		@endif
		@if(session()->get('typeExp') == 'admin')
		@if($aExp->type_exp == "expert")
		<form method="post" action="{{url(route('account_experts_expert_delete',['id_exp' => $aExp]))}}">
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
			<a class="modify" href="{{url(route('account_experts_expert_update',['id_exp' => $aExp]))}}">Modify</a>
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
<a id="back_btn" href="{{url(route('auth'))}}">❮ Log in</a><br>
@endif

@endsection