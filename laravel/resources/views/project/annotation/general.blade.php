@extends('layouts.app')

@section('content')

    <form method="post" action="{{ route('project.annotate.post', ['id' => $data->id_prj]) }}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2>{{ $data->name_prj }}</h2>
                </div>

                <div class="col-md-auto">
                    @if(session('annotation')['id_mode'] == 2)
                        <p>Remains : {{ session('annotation')['nb_annotation_remaining'] }} </p>
                    @endif
                </div>


            </div>

            <div class="row mt-4">
                <div class="col-sm" style="width: 500px;height: 350px">
                    <img class="img-display" style="margin: 0 auto;display: block;"
                         src="{{ asset('storage/app/datas/' . $pictures[$number]['pathname_data']) }}">
                    <input type="hidden" name="id_data" value="{{ $pictures[$number]['id_data'] }}">
                </div>
                <div class="col-sm getH">

                    @foreach ($categorys as $category)
                        <!-- <button type="button" id="answer{{$category->id_cat}}"
                                class="btn-select btn bg-light py-2 rounded h-32" data-toggle="button"
                                aria-pressed="false" autocomplete="off">-->
                        <div class="custom-control custom-checkbox">
                            <input type="radio" class="checkboxanswer{{$category->id_cat}}"
                                   id="customCheck{{$category->id_cat}}" name="category" value="{{$category->id_cat}}">
                            <label for="customCheck{{$category->id_cat}}">
                                {{$category['label_cat']}}
                            </label>
                        </div>
                        <!--</button>-->
                    @endforeach

                </div>
            </div>

            <div>
                <!--   <label for="customRange3">Example range</label> -->
                <h5 class="mt-5 ml-5">Are you confident with your answer ?</h5>
                <input type="range" class="custom-range testRange " name="expert_sample_confidence_level" min="1"
                       max="3" step="1" id="customRange3">
                <input type="submit" name="valider" value="Next" class="btn btn-primary m-3 text-light">
                <div class="divDisplay">
                    <div class=" d-none dd" id="dd1">
                        Not Confident
                    </div>
                    <div class=" d-inline-block dd" id="dd2">
                        Average
                    </div>
                    <div class=" d-none dd" id="dd3">
                        Really Confident
                    </div>
                </div>
            </div>
        </div>
    </form>

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

        .divDisplay {
            width: 90%;
            text-align: center;
        }

        .dd {
            background: #F8F9FA;
            color: black;
            font-size: 1.5em;
            padding: 20px;
            border-radius: 5px;
        }

        .h-32 {

            text-align: center;

        }

        .activeB {
            background-color: grey !important;
        }

        .getH {
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
        let divButton = document.getElementsByClassName("getH")

        range.addEventListener("change", function () {


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
        for (button of buttons) {
            button.addEventListener("click", function () {
                this.classList.add("activeB");
                console.log(button.classList);
                nbButtons++
            })
        }
        let heightButtons = 100 / nbButtons + "%"
        buttons.style.height = heightButtons

    </script>
    </div>



    </div>
@endsection
