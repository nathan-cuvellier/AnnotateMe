@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">

                <div class="text-center my-5">
                    <h2 class="">Welcome !</h2>
                    <p>Please login to your account</p>
                </div>

                @if(session()->has('error'))
                    <div class="alert alert-danger" role="alert">
                        {{ session()->pull('error') }}
                    </div>
                @endif

                @if(session('message'))
                    <div class="alert alert-danger" role="alert">
                        <b>{{ session('message') }}</b>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success" role="alert">
                        <b>{{ session('success') }}</b>
                    </div>
                @endif

                

                <form method="POST" action="{{ route('auth.login') }}">
                    @csrf

                    <div class="form-group">
                        <input id="email" type="email" class="form-control @error('mail_exp') is-invalid @enderror"
                               name="mail_exp" value="{{ old('mail_exp') }}" placeholder="Mail adress" required
                               autocomplete="email" autofocus>

                        @error('mail_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <input id="password" type="password"
                               class="form-control @error('pwd_exp') is-invalid @enderror" name="pwd_exp"
                               placeholder="Password" required
                               autocomplete="current-password">

                        @error('pwd_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div>
                        <a href="{{ route('account.reset') }}">forgot password ?</a>
                    </div>
                    <div class="form-group row">
                        <div class="mx-auto">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
