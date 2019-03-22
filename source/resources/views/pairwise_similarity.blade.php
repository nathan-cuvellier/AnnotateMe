@extends('layout.interfacesLayout')


@section('content')
    
  <form method="post" action="{{ url('/projects\/')}}{{$prj->id_prj}}/pairwise/valide"> 
    <input type="hidden" name="_token" value="{{ csrf_token() }}" >
    @foreach($elements as $aEle)
      <input type="hidden" name="elements[]" value="{{$aEle->id_data}}" >
    @endforeach
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
    
    <div id="annot">
      <div id="images_sim_1">
        <img class="imageAnnot_sim" src="<?php echo asset($elements[0]->pathname_data) ?>" />
      </div>

      <div id="cat" >
        <div class="choice"> 
          @foreach ($allCat as $aCat)
            <div>
              <label class="container_check" for="{{$aCat}}">{{$aCat['label_cat']}}
                <input class="choix_cat styled-input-single" id="{{$aCat}}" type="radio" name="cat" value={{$aCat["id_cat"]}}> 
                <span class="radiobtn v2"></span>
              </label>
            </div>
          @endforeach 
        </div>
        <p class="errors" id="errorCat">{{$mesErreurs[0]}}</p>
      </div>
      <div id="images_sim_2">
        <img class="imageAnnot_sim" src="<?php echo asset($elements[1]->pathname_data) ?>" />
      </div>
    </div>


    <p class="errors" id="errorIntervalle">{{$mesErreurs[1]}}</p>  

@endsection