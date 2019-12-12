@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row">
       <div class="col">
          <h2>Project Name</h2>
      </div>

      <div class="col-md-auto">
          <p>Annoted: 11</p>
      </div>

      <div class="col-md-auto">
          <p>10/43</p>
      </div>
  </div>

  <div class="row">
   <div  class="col-sm-4">
      <img class="img-fluid rounded" src="https://www.sciencesetavenir.fr/assets/img/2019/04/10/cover-r4x3w1000-5cadebdd93968-trou-noir-galaxie.jpg">
      <h6 class="text-center">Picture 1</h6>
  </div>

  
 <div  class="col-sm-4">
      <img class="img-fluid rounded" src="https://www.sciencesetavenir.fr/assets/img/2019/04/10/cover-r4x3w1000-5cadebdd93968-trou-noir-galaxie.jpg">
      <h6  class="text-center">Picture 2</h6>
  </div>

  <div  class="col-sm-4">
      <img class="img-fluid rounded" src="https://www.sciencesetavenir.fr/assets/img/2019/04/10/cover-r4x3w1000-5cadebdd93968-trou-noir-galaxie.jpg">
      <h6 class="text-center">Picture 3</h6>
  </div>
</div>


<div  class="col-sm getH">
  <h5 class="text-center m-3">Which one look like the most similar to the picture n°2 ?</h5>
        @for($i=1; $i<= 3; $i++)
        <div class="bg-light m-1 py-2 rounded h-32">
           

          <?php 
          if ($i == 1) {
            echo "picture ". $i;
          } else if ($i == 2) {
            $y = 3;
             echo "picture ". $y;
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
   <style type="text/css">

        .testRange {
              -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
              width: 90%; /* Specific width is required for Firefox. */
              background: transparent; /* Otherwise white in Chrome */
        }


      .testRange::-webkit-slider-thumb {
          -webkit-appearance: none;
          border: 1px solid #000000;
          height: 30px;
          margin-top: -13px;
          width: 30px;
          border-radius: 50px;
          background: #F8F9FA;
          cursor: pointer;
          box-shadow: 1px 1px 1px #000000, 0px 0px 1px #0d0d0d; /* Add cool effects to your sliders! */
        }

        .testRange::-webkit-slider-runnable-track {
          width: 90%;
          height: 2px;
          cursor: pointer;
          
          background: black;
          border-radius: 5px;
          border: 0.2px solid #010101;
        }
        .divDisplay{
            width: 90%;
            text-align: center;
        }
        .dd{
            background: #F8F9FA;
            color: black;
            font-size: 1.5em;
            padding: 20px;
            border-radius: 5px;
        }
        .h-32{

          text-align: center;
          overflow: hidden;
          text-overflow: ellipsis; 
          
        }
        .activeB{
          background-color: grey !important;
        }
        .getH{
          display: flex;
          flex-direction: column;
          justify-content: space-around;
        }

   </style>
   <script>


        let range = document.getElementById("customRange3")
        let dd1 = document.getElementById("dd1")
        let dd2 = document.getElementById("dd2")
        let dd3 = document.getElementById("dd3")
        let buttons = document.getElementsByClassName("h-32")
     

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
                    if (button.classList.contains('activeB')) {
                      this.classList.remove("activeB");
                        console.log( button.classList);
                       
                    } else  if (!button.classList.contains('activeB')) {
                    
                      this.classList.add("activeB");
                        console.log( button.classList);
                     
                    }

                     nbButtons++
                  })
                } 
           
   </script>
</div>



</div>

@endsection
