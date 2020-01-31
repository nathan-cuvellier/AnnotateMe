@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center m-5">
                <h2 class="">Update a Project</h2>
            </div>

            <form method="POST" action="{{ route('project.update.post', ['id' => $id]) }}" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="name_prj" class="col-form-label">Name</label>

                    <input id="name_prj" type="text" class="form-control @error('name_prj') is-invalid @enderror" name="name_prj" value="{{ str_replace('_', ' ',$project->name_prj) }}" maxlength="28" size="28" required autofocus>

                    @error('name_prj')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="desc_prj" class="col-form-label">Description</label>

                    <textarea id="desc_prj" type="text" class="form-control @error('desc_prj') is-invalid @enderror" name="desc_prj" maxlength="500" style="max-height: 350px; min-height: 100px;">{{ $project->desc_prj }}</textarea>

                    @error('desc_prj')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="id_mode" class="col-form-label">Annotation Session Mode</label>

                    <select id="id_mode" class="form-control" name="id_mode" data-toggle="tooltip" data-placement="bottom" title="Timer seconds or Number">
                        @foreach ($sessionModes as $sessionMode)
                        <option value="{{$sessionMode->id_mode}}" @if($sessionMode->id_mode == $project->id_mode) selected @endif>
                            {{$sessionMode->label_mode}}
                        </option>
                        @endforeach
                    </select>

                    @error('id_mode')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror


                </div>

                <div class="form-group">
                    <label id="labelLimitation" for="limit_prj" class="col-form-label">{{-- text put in javascript --}}</label>

                    <input id="limit_prj" type="number" class="form-control" name="limit_prj" value="{{ $project->limit_prj }}" min="0" max="3600" required>

                    @error('limit_prj')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="waiting_time_prj" class="col-form-label" title="waiting time between each annotation session of the project">Waiting time (in hour)</label>

                    <input type="number" min="0" required="required" name="waiting_time_prj" id="waiting_time_prj" value="{{ $project->waiting_time_prj }}" class="form-control @error('waiting_time_prj') is-invalid @enderror" aria-describedby="limitHelpInline">
                    <small id="limitHelpInline" class="text-muted">
                        Waiting time between each annotation session of this project
                    </small>
                    @error('waiting_time_prj')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <label for="" class="col-form-label">Participants</label>
                <div class="form-group">

                    <input class="form-control test" id="toggle-event" name="selectexperts" type="checkbox" data-toggle="toggle" data-on="Select Some Experts" data-off="Select All Experts">
                    <div id="console-event"></div>
                    <script>
                        $(function() {
                            $('#toggle-event').change(function() {
                                if ($(this).prop('checked') != true) {
                                    $('.toggle-hide').addClass('d-none')
                                } else {
                                    $('.toggle-hide').removeClass('d-none')
                                }
                            })
                        })
                    </script>
                </div>

                <div class="container toggle-hide d-none">
                    <hr class="my-2">
                    <div class="d-flex justify-content-left flex-wrap">
                        @foreach ($experts as $expert)
                        @if($expert->id_exp != session('expert')['id'] || $expert->type_exp != 'superadmin')
                        <div id="expert{{$expert->id_exp}}" class="form-group px-2 expert">
                            <button type="button" class="btn btn-primary" data-toggle="button" aria-pressed="false">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input checkboxexpert{{$expert->id_exp}}" id="customCheck{{$expert->id_exp}}" name="experts[{{$expert->id_exp}}]" @if(in_array($expert->id_exp, $idExpertsParticipation))
                                    checked="checked"
                                    @endif
                                    >
                                    <label class="custom-control-label" for="customCheck{{$expert->id_exp}}">
                                        {{$expert->name_exp." ".$expert->firstname_exp}}
                                    </label>
                                </div>
                            </button>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="online_prj" id="online_prj" @if($project->online_prj) checked="checked" @endif class="form-check-input @error('online_prj') is-invalid @enderror" aria-describedby="limitHelpInline">
                    <label class="form-check-label" for="online_prj">Project online</label>
                
                    @error('online_prj')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group row p-3">
                    <button type="submit" class="form-control btn btn-primary">
                        Save Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        console.log($('#id_mode').children("option:selected").val())
        if ($('#id_mode').children("option:selected").val() == 1) {
            console.log('test')
            $('#labelLimitation').text("Value of the limitation (in Minute)")
        } else if ($('#id_mode').children("option:selected").val() == 2) {
            $('#labelLimitation').text("Value of the limitation (in Number of Annotation)")
        }

    })

    $(document).ready(function() {
        $(".expert").click(function() {

            if ($(".checkbox" + this.id).prop('checked')) {
                $(".checkbox" + this.id).removeAttr('checked');
            } else {
                $(".checkbox" + this.id).attr('checked', true);
            }

        })
    })

    $(function() {
        $('#id_mode').change(function() {
            console.log($(this).children("option:selected").val())
            if ($(this).children("option:selected").val() == 1) {
                $('#labelLimitation').text("Value of the limitation (in Minute)")
            } else if ($(this).children("option:selected").val() == 2) {
                $('#labelLimitation').text("Value of the limitation (in Number of Annotation)")
            } else {
                $('#labelLimitation').text("Value of the limitation")
            }
        })
    })
</script>
@endsection