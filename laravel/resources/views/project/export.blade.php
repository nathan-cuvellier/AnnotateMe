
@extends('layouts.app')

@section('content')


    <h1>Are you sure you want to export annotations for this project ?</h1><br>


    <form method="post" action="{{url(route('projects_project_export',['id_prj' => $id_prj]))}}"
          enctype="multipart/form-data">
        @csrf


        <input type="submit" name="send" value="Export" class="myButton"><br>
        <br>
        @foreach($annot as $key => $value)
            <label id="export_check" class="container_check export" for='{{$key}}'>{{$key}}
                <input class="styled-input-single" type='checkbox' name='columExport[]' id='{{$key}}'
                       class='checkExport' value="{{$key}}">
                <span class="checkmark"></span>
            </label>
            <br>
        @endforeach
        <br><br><br>
        <p>
            <label id="export_check" class="container_check export" for='machineLearning'>CSV future user :
                <select class="input account" name='machineLearning' id='machineLearning' class='checkExport'
                        value="true">
                    <option value="machine">Machine</option>
                    <option value="user">User</option>
                </select>
            </label>
        </p>
        <!--- <p>
            <label id="export_check" class="container_check export" for='machineLearning'>CSV for Machine Learning ?
                <input  class="styled-input-single" type='checkbox' name='machineLearning' id='machineLearning' class='checkExport' value="true">
                <span class="checkmark"></span>
            </label>
        </p> --->

    </form>

    @if ($errors->has('columExport'))
        <div class="error">{{ $errors->first('columExport') }}</div>
    @endif

@endsection
