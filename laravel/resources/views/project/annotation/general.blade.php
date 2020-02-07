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
                    <img class="img-display" style="margin: 0 auto;display: block;"
                         src="{{ asset('storage/app/datas/' . $pictures[$number]['pathname_data']) }}">
                    <input type="hidden" name="id_data" value="{{ $pictures[$number]['id_data'] }}">
                </div>
                <div class="col-sm getH">

                @foreach ($categorys as $category)
                    <!-- <button type="button" id="answer{{$category->id_cat}}"
                                class="btn-select btn bg-light py-2 rounded h-32" data-toggle="button"
                                aria-pressed="false" autocomplete="off">-->
                        <div class="custom-control custom-checkbox rounded ">
                            <input type="radio" class="d-none pl-2"
                                   id="customCheck{{$category->id_cat}}" name="category" value="{{$category->id_cat}}">
                            <label for="customCheck{{$category->id_cat}}" class="w-75 pt-2 pb-2 btn btn-outline-primary">
                                {{$category['label_cat']}}
                            </label>
                        </div>
                        <!--</button>-->
                    @endforeach

                </div>
            </div>

            <div>
                <!--   <label for="customRange3">Example range</label> -->
                <h5 class="mt-5 ml-5">Confidence:</h5>
                <input type="range" class="custom-range testRange " name="expert_sample_confidence_level" min="1"
                       max="3" step="1" id="customRange3">
                <input type="submit" name="valider" value="Next" id="next" class="btn btn-primary m-3 text-light">
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
