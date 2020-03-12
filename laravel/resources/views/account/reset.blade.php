@extends('layouts.app')

@section('content')
    <div class="container">
        <h3 class="text-center mt-5 mb-5">Reset your password</h3>
        <div class="row">
            <div class="col-md-6 offset-md-3">

            @error('mail_exp')
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <b>Enter a valid email</b>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @enderror

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <p>{{ session('success')}}</p>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                
            @endif

                <form method="POST" method="{{ route('account.reset') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="mail_exp" required>
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="send" value="Send">
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

