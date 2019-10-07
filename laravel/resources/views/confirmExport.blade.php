@extends('layout.Projet')

@section('content')

    @if (session()->get('typeExp') != NULL && session()->get('typeExp') == true)
        <a id="back_btn" href="{{url(route('projects_list'))}}">❮ Back</a>
        <br>

        <h1>Your project has been exported !</h1>

        <form method="post" action="{{url(route('projects_project_export_download'))}}" enctype="multipart/form-data">
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
        <a id="back_btn" href="{{url(route('auth'))}}">❮ Log in</a><br>
    @endif

@endsection
