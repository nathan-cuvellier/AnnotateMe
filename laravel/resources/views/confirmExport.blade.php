@extends('layout.Projet')

@section('content')

    <a id="back_btn" href="{{url(route('projects_list'))}}">❮ Back</a>
    <br>

    <h1>Your project has been exported !</h1>

    <form method="post" action="{{url(route('projects_project_export_download'))}}" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <input type="submit" name="send" value="Download" class="myButton">
    </form>

    <?php if (isset($err)) {
        echo $err;
    }
    ?>

@endsection
