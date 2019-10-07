@extends('layout.interfacesLayout')

@section('content')
	
	<form method="post" action="{{ url('/projects\/')}}{{$prj->id_prj}}/classification/valide" > 
		<input type="hidden" name="_token" value="{{ csrf_token() }}" >
		<input type="hidden" name="elements[]" value="{{$elements[0]->id_data}}" >
		<input type="hidden" name="id" value="{{$prj->id_prj}}" >
		
		<?php 
			if ($errors->any()) {
				$mesErreurs = $errors->all();
				if ($errors->has('cat') && !$errors->has('confiance')) {
					$mesErreurs[1] = '';
				} else if (!$errors->has('cat') && $errors->has('confiance')) {
					$mesErreurs[1] = $mesErreurs[0];
					$mesErreurs[0] = "";
				}
			} else {
				$mesErreurs[0] = '';
				$mesErreurs[1] = '';
			}
		?>

			

		
		<div id="annot" >
			<div id="images">
				<img id="imageAnnot" src="<?php echo asset($elements[0]->pathname_data) ?>" />
			</div>

			<div id="cat" >
				@foreach ($allCat as $aCat)
					<div id="div_cat">
						<label class="container_check" for="{{$aCat}}">{{$aCat['label_cat']}}
							<input class="choix_cat styled-input-single" id="{{$aCat}}" type="radio" name="cat" value={{$aCat["id_cat"]}}> 
							<span class="radiobtn"></span>
						</label>
					</div>
					<br>
				@endforeach	
				<p class="errors" id="errorCat">{{$mesErreurs[0]}}</p>
			</div>
		</div>

		<p class="errors" id="errorIntervalle">{{$mesErreurs[1]}}</p>

@endsection