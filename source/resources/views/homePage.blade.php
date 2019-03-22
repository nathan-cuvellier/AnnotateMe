@extends('layout.Projet')

@section('content')


	<h1>Bienvenue !</h1>
	<h2>Entrez la clé d'accès de votre projet</h2>

	<form method="get" action="{{url('/')}}">
	@csrf
	<input type="text" style="width: 20vw;" class="form-projectacces" name="connexion" value="" placeholder="Clé d'accès"/>
	<br><br/>

	<input  class="myButton" type="submit" value="Valider l'annotation">
	</form>


@endsection