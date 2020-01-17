@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
       <div class="col">
          <h2>Project Name</h2>
      </div>

      <div class="col-md-auto">
          <p>Annoted: 10</p>
      </div>

      <div class="col-md-auto">
          <p>10/43</p>
      </div>
  </div>

  <div class="row">
   <div  class="col-sm-6">
      <img class="img-fluid rounded" src="https://www.sciencesetavenir.fr/assets/img/2019/04/10/cover-r4x3w1000-5cadebdd93968-trou-noir-galaxie.jpg">
      <h6 class="text-center">Picture 1</h6>
  </div>


 <div  class="col-sm-6">
      <img class="img-fluid rounded" src="https://www.sciencesetavenir.fr/assets/img/2019/04/10/cover-r4x3w1000-5cadebdd93968-trou-noir-galaxie.jpg">
      <h6  class="text-center">Picture 2</h6>
  </div>
</div>

<div  class="col-sm getH">
  <h5 class="text-center m-3">there are simularities between picture n°1 and picture n°2 ?</h5>
        @for($i=1; $i<= 3; $i++)


        <div class="bg-light m-1 py-2 rounded text-center ">

          <?php
          if ($i == 1) {
            echo "Yes";
          } else if ($i == 2) {
            $y = 3;
             echo "No";
          } else {
             echo "I don't know";
          }




          ?>
        </div>
        @endfor
</div>

<div>
 <!--   <label for="customRange3">Example range</label> -->
 <h5 class="mt-5 ml-5">Your awnser is confident ?</h5>
   <input type="range" class="custom-range testRange " min="1" max="3" step="1" id="customRange3">
    <a class="btn btn-primary m-3 text-light">Next</a>
    <div class="divDisplay">
       <div class=" d-none dd" id="dd1">Not Confident</div>
       <div class=" d-inline-block dd" id="dd2">Average</div>
       <div class=" d-none dd" id="dd3">Really Confident</div>
   </div>
   <script>


        let range = document.getElementById("customRange3")
        let dd1 = document.getElementById("dd1")
        let dd2 = document.getElementById("dd2")
        let dd3 = document.getElementById("dd3")
        let buttons = document.getElementsByClassName("h-32")
        let divButton = document.getElementsByClassName("getH")

        console.log(dd1)
        range.addEventListener("change", function() {


                if (range.value == 1) {
                    dd1.classList.remove("d-none");
                    dd1.classList.add("d-inline-block")

                    dd2.classList.add("d-none")
                    dd2.classList.remove("d-inline-block");

                    dd3.classList.add("d-none")
                    dd3.classList.remove("d-inline-block");

                } else if (range.value == 2) {

                    dd1.classList.add("d-none")
                    dd1.classList.remove("d-inline-block");

                    dd2.classList.add("d-inline-block")
                    dd2.classList.remove("d-none");

                    dd3.classList.add("d-none")
                    dd3.classList.remove("d-inline-block");

                } else if (range.value == 3) {
                    dd1.classList.add("d-none")
                    dd1.classList.remove("d-inline-block");

                    dd2.classList.add("d-none")
                    dd2.classList.remove("d-inline-block");

                    dd3.classList.remove("d-none");
                    dd3.classList.add("d-inline-block")
                }



        })
          let nbButtons = 3
           for(button of buttons){
                  button.addEventListener("click",function(){
                      this.classList.add("activeB");
                        console.log( button.classList);
                        nbButtons++
                  })
                }
            let heightButtons = 100/nbButtons + "%"
            console.log(heightButtons)
            buttons.style.height =  heightButtons

   </script>
</div>



</div>

@endsection
