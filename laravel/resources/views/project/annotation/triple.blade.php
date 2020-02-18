
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
                <div class="col-sm" >
                  <h5 class="text-center m-3">Which image look the most similar to this ?</h5>
                    <img class="img-display rounded" style="margin: 0 auto;display: block;"
                         src="{{ asset('storage/app/datas/' . $pictures[$number[0]]['pathname_data']) }}">
                    <input type="hidden" name="id_data" value="{{ $pictures[$number[0]]['id_data'] }}">
                </div>

                <div class="inputs col-sm">
                    <div class="stacked custom-control custom-checkbox rounded ">
                        <input type="radio" class="d-none pl-2"
                               id="customCheck" name="category" value="{{$categorys[1]->id_cat}}">
                        <label for="customCheck" class="btn btn-outline-primary">
                            <img class="img-display rounded" style="max-width: 60%;"
                     src="{{ asset('storage/app/datas/' . $pictures[$number[1]]['pathname_data']) }}">
                        </label>
                    </div>

                    <div class="stacked custom-control custom-checkbox rounded ">
                        <input type="radio" class="d-none pl-2"
                               id="customCheck" name="category" value="{{$categorys[2]->id_cat}}">
                        <label for="customCheck" class="btn btn-outline-primary">
                            <img class="img-display rounded" style="max-width: 60%;"
                     src="{{ asset('storage/app/datas/' . $pictures[$number[2]]['pathname_data']) }}">
                        </label>
                    </div>
                </div>
            </div>

            <div class="container">
                <div class="row">
                    <h5 class="col-sm- pt-3">Confidence:</h5>
                    <input class="col custom-range testRange" type="range" name="expert_sample_confidence_level" min="1" max="3" step="1" id="customRange3">

                    <button type="submit" class="btn-block btn btn-lg btn-primary" id="next">Next</button>
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
        document.addEventListener("DOMContentLoaded", function(){
            let bNext = document.getElementById("next")
            bNext.disabled = true

            let bInputs = document.querySelectorAll(".stacked label")
            for (let bInput of bInputs) {

                bInput.addEventListener("click", function(){
                    for (let b of bInputs) {
                        b.classList.add('btn-outline-primary')
                        b.classList.remove('btn-primary')
                    }

                    this.classList.remove('btn-outline-primary')
                    this.classList.add('btn-primary')

                    bNext.disabled = false;
                })
            }
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

<!--
