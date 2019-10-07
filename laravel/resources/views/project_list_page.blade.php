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

	
	@if (session()->get('typeExp') != NULL && session()->get('typeExp') == true) 
		<style type="text/css">
			table, th, td {
			    border: 1px solid black;
			    border-collapse: collapse;
			    margin-left: auto;
				margin-right: auto;
			}
			th{ padding: 25px 20px 25px 20px; }
			a{ text-decoration: none; }
			#name-cell{
				min-width: 300px;
				max-width: 50vw;
				text-decoration: none;
			}
			#delete-btn{
				cursor: pointer;
			}
		</style>

		@if(session()->has('message'))
			<p id="message"> {{session()->pull('message')}} </p> <!-- Get the message value and forget it -->
		@endif

		<h1>Search project</h1><br>
		
		<form method="get" action="{{url('/projects')}}" enctype="multipart/form-data">
			@csrf
			<input class="input account" type="hidden" name="_token" id="token" value="{{csrf_token()}}">
		
			<input type="text" class="input" name="search" placeholder="Search...">
			<select name="interface" class="input account" id="select_listpage">
				<option value="all" selected>All interface types</option>
				<option value="1">Classification</option>
				<option value="2">Pairwise similarity</option>
				<option value="3">Tripletwise similarity</option>
			</select>
			<select name="session_mode" class="input account" id="select_listpage">
				<option value="all" selected>All limitation modes</option>
				<option value="1">Time</option>
				<option value="2">Number of annotations</option>
			</select> 
			<button class="MyButton" type="submit" name="submit_search">SEARCH</button>
			<button class="MyButton" type="submit" value="null">RESET</button>
		</form>
		
		<br><br>
		<hr>
		<br>
		<p id="del_response"></p>
		<br>
		<table>
			<tr>
				<th>ID</th>
				<th>Project Name</th>
				<th>Project Type</th>
				<th>Export Data</th>
				<th>My expert project<br>confidence level</th>
				@if (session()->get('typeExp') != NULL && (session()->get('typeExp') == 'superadmin' || session()->get('typeExp') == 'admin')) 
					<th>Update settings</th>
					<th>Delete project</th>
				@endif
			</tr>
		<!-- 1 line = 1 project -->
		@foreach ($projects as $project)
			@foreach ($modes as $mode)
				@foreach($listeInterfaces as $interface)
            		@if ($project->id_int == $interface->id_int)
						@if($project->id_mode == $mode->id_mode)
							<tr>
								<!-- ID of the project -->
								<th>{{$project->id_prj}}</th>

								<form id="confidentForm" method="post" id="prjName" action="{{url('/projects\/')}}{{$project->id_prj}}" enctype="multipart/form-data">
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<!-- Name of the project -->
									<th id="name-cell"> <button class="buttonList" type="submit" class="project-details">{{$project->name_prj}}</button> </th>

									<!-- Limitation mode of the project ( and value ) -->
									@if($project->id_mode == 1)
										<th>{{$interface->label_int}} <br> {{$mode->label_mode}} ({{$project->limit_prj}} minutes)</th>	
									@else
										<th>{{$interface->label_int}} <br> {{$mode->label_mode}} ({{$project->limit_prj}} annotations)</th>
									@endif
									
									<!-- Project data export button -->
									<th><a href="{{url('/projects\/')}}{{$project->id_prj}}/export">Export</a></th>

									<!-- Change the level of a expert for a project -->

										@foreach($particitionProject as $aPart)
											@if($aPart->id_prj == $project->id_prj)
												<th>
													<p class="interval">Expert project<br>confidence level :<br> <input class="intervalle_input" id="numberconf" name="confiance" type="range" min="0" max="2" step="1" value="{{$aPart->expert_project_confidence_level}}"><div id="trust2"><p id="doubt2">doubt</p><p id="confident2">confident</p><p id="very_confident2">highly confident</p></div></p>
												</th>
											@endif
										@endforeach

									<!-- If the user is an admin/superadmin -> Delete project button appears -->
									@if (session()->get('typeExp') != NULL && (session()->get('typeExp') == 'superadmin' || session()->get('typeExp') == 'admin')) 
										<th><a href="{{url('/projects\/')}}{{$project->id_prj}}/update">Update</a></th>
										<th><a href="{{url('/projects\/')}}{{$project->id_prj}}/delete" id="delete-btn">Delete</a></th>	
									@endif

								</form>
							</tr>
						@endif
					@endif
        		@endforeach
			@endforeach
		@endforeach

		</table>
	@else
		<h1 style="color:red;">You are not connected</h1>
		<a id="back_btn" href="{{url('/')}}">❮ Log in</a><br>
	@endif

	<script type="text/javascript">
		localStorage.setItem("distance",  0);
	</script>

@endsection