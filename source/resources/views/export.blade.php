@extends('layout.Projet')

@section('content')


    
    @if (session()->get('typeExp') != NULL && session()->get('typeExp') == true) 
        <a id="back_btn" href="{{url('/projects/')}}">❮ Back</a><br>


        <h1>Are you sure you want to export annotations for this project ?</h1><br>
        
        <form method="post" action="{{url('/projects\/')}}{{$id_prj}}/exportDatas" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >

            
            <input type="submit" name="send" value="Export" class="myButton"><br>

            @foreach($annot as $key => $value)
                <label id="export_check" class="container_check export" for='{{$key}}'>{{$key}}
                 <input  class="styled-input-single" type='checkbox' name='columExport[]' id='{{$key}}' class='checkExport' value="{{$key}}">
                 <span class="checkmark"></span>
                </label>
            @endforeach
            <br><br><br>
            <p>
                <label id="export_check" class="container_check export" for='machineLearning'>CSV future user :
                    <select class="input account" name='machineLearning' id='machineLearning' class='checkExport' value="true">
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
        
    @else
        <h1 style="color:red;">You are not connected</h1>
        <a id="back_btn" href="{{url('/')}}">❮ Log in</a><br>
    @endif

@endsection