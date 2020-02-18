@extends('layouts.app')

@section('content')

    
    @error('id_data')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="alert alert-warning w-50 text-center" role="alert"><b>Error</b></div>
        </div>
    </div>
    @enderror

    @error('category')
    <div class="container">
        <div class="d-flex justify-content-center">
            <div class="alert alert-warning w-50 text-center" role="alert"><b>You must select a category</b></div>
        </div>
    </div>
    @enderror

    <form method="post" action="{{ route('project.annotate.post', ['id' => $data->id_prj]) }}">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col">
                    <h2>{{ str_replace('_', ' ', $data->name_prj) }}</h2>
                </div>

                <div class="col-md-auto">
                    @if(session('annotation')['id_mode'] == 2)
                        <p>Remains : {{ session('annotation')['nb_annotation_remaining'] }} </p>
                    @else
                        <p id="time">Remains : loading...</p>
                    @endif

                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm" style="width: 500px;height: 350px">
                    <img class="img-display rounded" style="margin: 0 auto;display: block;"
                         src="{{ asset('storage/app/datas/' . $pictures[$number]['pathname_data']) }}">
                    <input type="hidden" name="id_data" value="{{ $pictures[$number]['id_data'] }}">
                </div>

                <div class="inputs col-sm">

                    @foreach ($categorys as $category)
                        <div class="stacked custom-control custom-checkbox rounded ">
                            <input type="radio" class="d-none pl-2"
                                   id="customCheck{{$category->id_cat}}" name="category" value="{{$category->id_cat}}">
                            <label for="customCheck{{$category->id_cat}}" class="btn btn-outline-primary">
                                {{$category['label_cat']}}
                            </label>
                        </div>
                    @endforeach

                </div>
            </div>

            <div class="container">
                <div class="row">
                    <h5 class="col-sm- pt-3">Confidence:</h5>
                    
                    <input class="col custom-range testRange" type="range" name="expert_sample_confidence_level" min="1"
                           max="3" step="1" id="customRange3">

                    <button type="submit" class="btn-block btn btn-lg btn-primary" disabled id="next">Next</button>
                    
                    <!--
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
                    -->
                </div>
            </div>
        </div>
    </form>
    
    <style type="text/css">
        .inputs {
            display: flex;
            flex-direction: column;
        }
        .stacked { 
            flex: 1;
            display: flex;
            justify-content: center;
            flex-direction: column;

            padding: 0px;
        }

        .stacked label {
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 1.2em;
        }
    </style>

    <script type="text/javascript">
    $(document).ready(function(){
        $('#next').prop('disabled', true);

        $('input').click(function(){
            if($(this).is(':checked'))
            {
                $('#next').prop('disabled', false);
            }
            else
            {
                $('#next').prop('disabled', true);
            }
        });
    });
    </script>

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
                this.classList.add("activeB")
                nbButtons++
            })
        }
        let heightButtons = 100 / nbButtons + "%"
        //buttons.style.height = heightButtons

        /// get all categories
        let lis = document.querySelectorAll('[for^="customCheck"]')
        console.log(lis)
        lis.forEach((category) => {
            category.addEventListener('click', () => {
                lis.forEach((category) => {
                    category.classList.add('btn-outline-primary')
                    category.classList.remove('btn-primary')
                })
                category.classList.remove('btn-outline-primary')
                category.classList.add('btn-primary')
            })
        })

        {{-- If the limit of project is in time --}}
        @if(session()->has('annotation.time_end_annotation'))
            let countDown = () => {
                let date_limit = new Date("{{ session()->get('annotation.time_end_annotation') }}")

                let now = 0
                let calcDiff = 1

                $.ajax({
                    url: "{{ asset('date.php') }}",
                    complete: function (response) {
                        now = new Date(response.responseText)

                        let diff = (date_limit - now) / 1000
                        let minutes = Math.floor(diff / 60)
                        diff -= minutes * 60
                        let secondes = Math.floor(diff)
                        document.querySelector('#time').innerText = "Remains : " + minutes + ":" + secondes
                        calcDiff = (date_limit - now) / 1000
                        if(calcDiff <= 0) {
                            document.querySelector('#time').innerText = "Elapsed time, last annotation"
                            clearInterval(idCountDown)
                        }


                    },
                    error: function () {
                        document.querySelector('#time').innerText = "Remains : Error"
                    }
                })
            }

            countDown()

            let idCountDown = setInterval(countDown, 1000);
        @endif
    
    </script>
    
@endsection
