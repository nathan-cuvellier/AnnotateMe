@extends('layout.interfacesLayout')

@section('content')

	<div id="triple">

		<form method="post" action="{{ url('/projects\/')}}{{$prj->id_prj}}/tripletwise/valide">

		    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
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

					
			
		    <div id="images_triple">
		    @foreach($elements as $aEle)
		    	<input type="hidden" name="elements[]" value="{{$aEle->id_data}}">

		    	<div id="{{$aEle->id_data}}" class="img_trpl_div div">
		        	<img class="imageAnnot_triple" src="<?php echo asset($aEle->pathname_data) ?>" />
		        </div>
		    @endforeach
				</div>

		    <!-- Display the category -->
		    <div class="choice_triple"> 
                @foreach ($allCat as $aCat)
					  <div id="triple_choice_div">
		                	<label class="container_check" for="{{$aCat}}">{{$aCat['label_cat']}}
		                		<input class="choix_cat styled-input-single" id="{{$aCat}}" type="radio" name="cat" value={{$aCat["id_cat"]}}> 
		                		<span class="radiobtn v3"></span>
		                	</label>
		                </div>
                @endforeach
                
            </div>
            <p class="errors" id="errorCat">{{$mesErreurs[0]}}</p>
	</div>
	
@endsection