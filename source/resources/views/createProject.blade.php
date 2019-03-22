@extends('layout.Projet')

@section('title', 'Créer un projet')

@section('content')

<style type="text/css">
    
    .input.account
    {
        display: block;
        margin-left: 42.5%;
    }

</style>
<script type="text/javascript" src="{{ URL::asset('js/createProject.js') }}"></script>

        <a id="back_btn" href="{{url('/projects/')}}">❮ Back</a><br>
        <h1>Create Project</h1><br>
        <form id="form_project" method="post" action="{{ url('projectSave') }}" enctype="multipart/form-data">
            @csrf
            <input class="input account" type="hidden" name="_token" id="token" value="{{csrf_token()}}">
            <label for="name_prj">Name</label>
            <input class="input account" type="text" name="name_prj" value="{{old('name_prj')}}">

            @if ($errors->has('name_prj'))
                <div class="error">{{ $errors->first('name_prj') }}</div>
            @endif

            <label for="desc_prj">Description</label>
            <input class="input account" type="text" name="desc_prj" value="{{old('desc_prj')}}">

            @if ($errors->has('desc_prj'))
                <div class="error">{{ $errors->first('desc_prj') }}</div>
            @endif

            <label for="id_mode">Annotation session Mode</label>
            <select class="input account" name="id_mode"  id="selectlimit" onchange="displayLimitationValue()">
                @foreach ($listeModes as $mode)
                    <option value="{{$mode->id_mode}}">
                        {{$mode->label_mode}}
                    </option>
                @endforeach
            </select>

            <label for="limit_prj" id="labelValue">Value of the limitation (in second)</label>
            <input class="input account" type="text" name="limit_prj" value="{{old('limit_prj')}}">

            @if ($errors->has('limit_prj'))
                <div class="error">{{ $errors->first('limit_prj') }}</div>
            @endif

            <label for="id_int">Interface type</label>
            <select class="input account" name="id_int">
                @foreach ($listeInterfaces as $interface)
                <option value="{{$interface->id_int}}">
                    {{$interface->label_int}}
                </option>
                @endforeach
            </select>

            

            @if ($errors->has('id_int'))
                <div class="error">{{ $errors->first('id_int') }}</div>
            @endif

            <label for="datas" class="label-file">Folders to annotate (.zip)</label><br>
            <input type="file" class="input-file" id="datas" accept=".zip" name="datas">


            @if ($errors->has('datas'))
                <div class="error">{{ $errors->first('datas') }}</div>
            @endif
            
           

            <br><br><label for="id_expAdd">Allowed experts</label>
            <input class="input account" name="id_exp" type="hidden" value="{{session()->get('idExp')}}">

            
            <div class="multiselect">
                <div class="selectBox" onclick="showCheckboxes()">
                    <select class="input account">
                        <option>Select an Expert</option>
                    </select>
                    <div class="overSelect"></div>
                </div>
                <div id="checkboxes">
                    @foreach ($allExpertNoAdmin as $aExp)
                        <label for="id_expAdd">{{$aExp->name_exp." ".$aExp->firstname_exp}}</label>
                        <input class="check" type="checkbox" name="check_ExpList[]" value="{{$aExp->id_exp}}">
                    @endforeach
                </div>
            </div>

            <input class="input account" name="id_exp" type="hidden" value="{{session()->get('idExp')}}">
            <button class="myButton" type="submit">
                Create
            </button>
        </form>


@endsection