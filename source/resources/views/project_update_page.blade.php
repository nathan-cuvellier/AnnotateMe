@extends('layout.Projet')

@section('title', 'Project update')

@section('content')

<style type="text/css"> 
    .input.account
    {
        display: block;
        margin-left: 42.5%;
    }
</style>
        
<script type="text/javascript" src="{{ URL::asset('js/createProject.js') }}"></script>


    <!-- Check if the user connected -->
    @if (session()->get('typeExp') != NULL && session()->get('typeExp') == true) 
        <a id="back_btn" href="{{url('/projects/')}}">❮ Back</a><br>

        <h1>Update Project</h1><br>
        <form id="form_project" method="post" action="{{url('/projects\/')}}{{$project[0]->id_prj}}/update-confirmed" enctype="multipart/form-data">
            @csrf
            <input class="input account" type="hidden" name="_token" id="token" value="{{csrf_token()}}">

            <!-- Name of the project -->
            <label for="name_prj">Name</label>
            <input class="input account" type="text" name="name_prj" value="{{$project[0]->name_prj}}">

            @if ($errors->has('name_prj'))
                <div class="error">{{ $errors->first('name_prj') }}</div>
            @endif

            <!-- Description of the project -->
            <label for="desc_prj">Description</label>
            <input class="input account" type="text" name="desc_prj" value="{{$project[0]->desc_prj}}">

            @if ($errors->has('desc_prj'))
                <div class="error">{{ $errors->first('desc_prj') }}</div>
            @endif

            <!-- Interface used for annotation (Not editable) -->
            <label for="id_interface">Type of interface</label>
            @foreach ($listeInterfaces as $interface)
                @if($interface->id_int == $project[0]->id_int)
                    <input class="input account" type="text" name="id_interface" value="{{$interface->label_int}}" disabled readonly>
                @endif
            @endforeach
            
            <!-- Limitation mode of the project -->
            <label for="limit_prj">Annotation session Mode</label>
            <select class="input account" name="id_mode" id="selectlimit" onchange="displayLimitationValue()">
                @foreach ($listeModes as $mode)
                   @if($mode->id_mode == $project[0]->id_mode)
                        <option selected="selected" value={{strtolower($mode->id_mode)}}>{{$mode->label_mode}}</option>
                    @else
                        <option value="{{$mode->id_mode}}">{{$mode->label_mode}}</option>
                    @endif
                
                @endforeach
            </select>

            <!-- Value of the annotation session limit -->
            <label for="limit_prj" id="labelValue">Value of the limitation (in second)</label>
            <input class="input account" type="text" name="limit_prj" value="{{$project[0]->limit_prj}}">

            @if ($errors->has('limit_prj'))
                <div class="error">{{ $errors->first('limit_prj') }}</div>
            @endif

            <!-- New folders to add -->
            <label for="datas" class="label-file">Add .zip folders to annotate</label><br>
            <input type="file" id="datas" accept=".zip" name="datas">
            
            <div class="multiselect">
                <div class="selectBox" onclick="showCheckboxes()">
                    <select class="input account">
                        <option>Select an Expert</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="checkboxes">
                    @foreach ($allExpertParticipation as $aExp)
                            @if($aExp[1])
                                <label for="id_expAdd">{{$aExp[0]["name_exp"]." ".$aExp[0]["firstname_exp"]}}</label>
                                <input class="check" type="checkbox" name="check_ExpList[]" value="{{$aExp[0]['id_exp']}}" checked></input>
                            @else
                                <label for="id_expAdd">{{$aExp[0]["name_exp"]." ".$aExp[0]["firstname_exp"]}}</label>
                                <input class="check" type="checkbox" name="check_ExpList[]" value="{{$aExp[0]['id_exp']}}"></input>
                            @endif
                    @endforeach
                </div>
            </div>
            
            <!-- Validation button -->
            <button class="myButton" type="submit">Update project</button>
        </form>

    <!-- If the user isn't connected, access blocked and he's invited to log on -->
    @else
        <h1 style="color:red;">You are not connected</h1>
        <a id="back_btn" href="{{url('/')}}">❮ Log in</a><br>
    @endif

@endsection