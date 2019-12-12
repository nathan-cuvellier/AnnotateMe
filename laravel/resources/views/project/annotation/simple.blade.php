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
        <div  class="col-xl">
            <img class="img-fluid rounded" src="https://www.sciencesetavenir.fr/assets/img/2019/04/10/cover-r4x3w1000-5cadebdd93968-trou-noir-galaxie.jpg">
        </div>

        <div  class="col-sm getH btn-group-vertical">
            @for($i=1; $i<= 5; $i++)
                <button type="button" id="answer{{$i}}" class="btn-select btn bg-light py-2 rounded h-32" data-toggle="button" aria-pressed="false" autocomplete="off">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input checkboxanswer{{$i}}" id="customCheck" name="answers[{{$i}}]">
                        <label class="custom-control-label" for="answer{{$i}}">
                            Bouton  Bouton  Bouton  Bouton  Bouton  Bouton  Bouton  Bouton  Bouton  Bouton
                        </label>
                    </div>
                </button>
            @endfor
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded',function(){
            let btnselects = document.getElementsByClassName("btn-select")

            for(let btnselect of btnselects)
            {
                btnselect.addEventListener('click', function(){
                    let check = document.querySelector(".checkbox" + this.id)
                    if (check.checked == false) {
                        for(let b of btnselects) {
                            document.querySelector(".checkbox" + b.id).checked = false
                            b.classList.add("bg-light")
                            b.classList.add("bg-primary")
                        }

                        document.querySelector(".checkbox" + this.id).checked = true;  
                        this.classList.add("bg-primary")
                        this.classList.remove("bg-light")
                    }
                })
            }
        })

    </script>

    <div>
        <!--   <label for="customRange3">Example range</label> -->
        <h5 class="mt-5 ml-5">Are you confident with your answer?</h5>
        <!-- voir slider a https://css-tricks.com/value-bubbles-for-range-inputs/ -->
        <div class="d-flex flex-row justify-content-sm-between">
            
            <input type="range" class="custom-range testRange " min="1" max="3" step="1" id="customRange3">
            <a class="btn btn-primary ml-3 text-light">Next</a>
        </div>
        <div class="divDisplay">
            <div class=" d-none dd" id="dd1">Not Confident</div>
            <div class=" d-inline-block dd" id="dd2">Average</div>
            <div class=" d-none dd" id="dd3">Really Confident</div>
        </div>
    </div>
</div>
@endsection

<style type="text/css">
    .testRange {
        -webkit-appearance: none; /* Hides the slider so that custom slider can be made */
        width: 90%; /* Specific width is required for Firefox. */
        background: transparent; /* Otherwise white in Chrome */
    }


    .testRange::-webkit-slider-thumb {
        -webkit-appearance: none;
        border: 1px solid #000000;
        height: 20px;
        margin-top: -10px;
        width: 20px;
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
    }
    .activeB{
        background-color: grey !important;
    }
    .getH{
    }

    .btn-select {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
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
