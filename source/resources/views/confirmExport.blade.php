@extends('layout.Projet')

@section('content')

    @if (session()->get('typeExp') != NULL && session()->get('typeExp') == true) 
        <a id="back_btn" href="{{url('/projects/')}}">❮ Back</a>
        <br>

        <h1>Your project has been exported !</h1>
        
        <form method="post" action="{{url('/projects\/')}}{{$id_prj}}/download" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" >

            <input type="submit" name="send" value="Download" class="myButton">
        </form>

        <?php if(isset($err))
                {
                    echo $err;
                }
         ?>
    @else
        <h1 style="color:red;">You are not connected</h1>
        <a id="back_btn" href="{{url('/')}}">❮ Log in</a><br>
    @endif

@endsection