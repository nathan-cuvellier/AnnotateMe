@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mt-5 mb-5">Reset your password</h3>
    <div class="row">
        <div class="col-md-6 offset-md-3">

            @if(isset($error))
            <div class="alert alert-warning" role="alert">
                <b>{!! $error !!}</b>
            </div>
            @else

            <form method="POST" method="{{ route('account.reset') }}">
                @csrf
                <div class="form-group">
                    <label for="email">New passowrd</label>
                    <input type="password" class="form-control @error('pwd_exp') is-invalid @enderror" name="pwd_exp" required>

                    @error('pwd_exp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Confirmation password</label>
                    <input type="password" class="form-control" name="pwd_exp_confirmation" required>
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-primary" name="send" value="Send">
                </div>
            </form>
            @endif
        </div>
    </div>
</div>

@endsection