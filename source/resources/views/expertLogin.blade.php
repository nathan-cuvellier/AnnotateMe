@extends('layout.Projet')
<?php 

	if (session()->get('typeExp') != NULL && (session()->get('typeExp') == "admin" || session()->get('typeExp') == "superadmin")) 
	{
        echo "<a id='create_account' href=\"".url('register')."\">Créer un compte</a>";
    }

    if (session()->get('typeExp') != NULL && session()->get('typeExp') == true)
    {
        echo "<a id='deco' href=\"".url('logout')."\">Déconnexion</a>";
    }
	

 ?>

@section('content')
	@if (session()->get('typeExp') == NULL)
		<h1>Welcome !</h1><br>
		<h2>Please login to your account: </h2><br>
		<form method="post" action="{{ route('check') }}">


			<?php
				

				if ($errors->any())
				{
			        $mesErreurs = $errors->all();
			        if($errors->has('mail_exp') && !$errors->has('pwd_exp'))
					{
						$mesErreurs[1]='';
					}
					else if(!$errors->has('mail_exp') && $errors->has('pwd_exp'))
					{
						$mesErreurs[1]=$mesErreurs[0];
						$mesErreurs[0]="";
					}
				}
				else
				{
					$mesErreurs[0]='';
					$mesErreurs[1]='';
				}


			 ?>


			@csrf
			<input class="input" type="mail" name="mail_exp" placeholder="Mail adress"><br>
			<p class="error_create" id="erreurMail">{{$mesErreurs[0]}}</p>
			<input class="input" type="password" name="pwd_exp" placeholder="Password"><br>
			<p class="error_create" id="errorIntervalle2">{{$mesErreurs[1]}}</p>

			<?php 
				if(isset($passError))
					 echo "<p class=\"error_create\" id=\"errorIntervalle\">".$passError."</p>";
			 ?>

		    <button class="myButton" type="submit" value="Se connecter">
		        log in
		    </button>
		</form>
	@else
	<script type="text/javascript">
	    window.location = "./projects";
	</script>
		
	@endif
@endsection

