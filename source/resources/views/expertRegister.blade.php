@extends('layout.Projet')

@section('title', 'S\'inscrire')

@section('content')

        <style type="text/css"> 

            .input.account
            {
                display: block;
                margin-left: 42.5%;
            }

            
        </style>

        <a id="back_btn" href="{{url('/projects/')}}">❮Back</a>
        <h1>Create account</h1><br>
        <form id="" method="post" action="{{ route('save') }}"><input type="hidden" name="_token" value="{{ csrf_token() }}" >
            @csrf
            <label for="name_exp">Lastname</label>
            <input class="input account" type="text" name="name_exp" value="{{old('name_exp')}}">

            @if ($errors->has('name_exp'))
                <div class="error_create">{{ $errors->first('name_exp') }}</div>
            @endif


            <label for="firstname_exp">Firstname</label>
            <input class="input account" type="text" name="firstname_exp" value="{{old('firstname_exp')}}">

            @if ($errors->has('firstname_exp'))
                <div class="error_create">{{ $errors->first('firstname_exp') }}</div>
            @endif

            @if (session()->get('typeExp') != NULL && session()->get('typeExp') == "superadmin") 
                <label for="type_exp">Type of expert</label>
                <select name="type_exp" class="input account">
                    <option value="expert">Expert</option>
                    <option value="admin">Admin</option>
                </select>
                @if ($errors->has('type_exp'))
                <div class="error_create">{{ $errors->first('type_exp') }}</div>
                @endif
            @else
                <input type="hidden" name="type_exp" value="expert">
            @endif

            

            <label for="bd_date_exp">Birth date</label>
            <input class="input account" type="date" name="bd_date_exp" value="{{old('bd_date_exp')}}">

            @if ($errors->has('bd_date_exp'))
                <div class="error_create">{{ $errors->first('bd_date_exp') }}</div>
            @endif

            <label for="sex_exp">Sex</label>
            <select class="input account" name="sex_exp">
                <option value="h">Man</option>
                <option value="f">Woman</option>
            </select>

            @if ($errors->has('sex_exp'))
                <div class="error_create">{{ $errors->first('sex_exp') }}</div>
            @endif

            <label for="address_exp">Address</label>
            <input class="input account" type="text" name="address_exp" value="{{old('address_exp')}}">

            @if ($errors->has('address_exp'))
                <div class="error_create">{{ $errors->first('address_exp') }}</div>
            @endif

            <label for="pc_exp">Postal code</label>
            <input class="input account" type="text" name="pc_exp" value="{{old('pc_exp')}}">

            @if ($errors->has('pc_exp'))
                <div class="error_create">{{ $errors->first('pc_exp') }}</div>
            @endif

            <label for="city_exp">City</label>
            <input class="input account" type="text" name="city_exp" value="{{old('city_exp')}}">

            @if ($errors->has('city_exp'))
                <div class="error_create">{{ $errors->first('city_exp') }}</div>
            @endif

            <label for="mail_exp">Mail</label>
            <input class="input account" type="mail" name="mail_exp" value="{{old('mail_exp')}}">

            @if ($errors->has('mail_exp'))
                <div class="error_create">{{ $errors->first('mail_exp') }}</div>
            @endif

            <label for="tel_exp">Phone</label>
            <input class="input account" type="tel" name="tel_exp" value="{{old('tel_exp')}}">

            @if ($errors->has('tel_exp'))
                <div class="error_create">{{ $errors->first('tel_exp') }}</div>
            @endif

            <label for="pwd_exp">Password</label>
            <input class="input account" type="password" name="pwd_exp" >

            @if ($errors->has('pwd_exp'))
                <div class="error_create">{{ $errors->first('pwd_exp') }}</div>
            @endif
            
            <label for="conf_pwd_exp">Confirm Password</label>
            <input class="input account" type="password" name="conf_pwd_exp">

            @if ($errors->has('conf_pwd_exp'))
                <div class="error_create">{{ $errors->first('conf_pwd_exp') }}</div>
            @endif
            
            <button class="myButton" type="submit">
                Register
            </button>

        </form>
  

@endsection