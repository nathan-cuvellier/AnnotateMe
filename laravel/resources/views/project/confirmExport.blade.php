@extends('layout.Projet')

@section('content')

    <br>

    <h1>Your project has been exported !</h1>

    <form method="post" action="{{url(route('projects_project_export_download'))}}" enctype="multipart/form-data">
        @csrf

        <input type="submit" name="send" value="Download" class="myButton">
    </form>

    <?php if (isset($err)) {
        echo $err;
    }
    ?>

@endsection
