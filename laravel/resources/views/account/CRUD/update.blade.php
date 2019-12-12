@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center bg-light rounded">
            <div class="col-12 text-center">
                <h2>Update account</h2>
            </div>
            <form class="w-100 p-4" method="POST"
                  action="{{ route('account.update.post', ['id' => $expert->id_exp]) }}">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name_exp" class="col-form-label">Lastname</label>

                            <input id="name_exp" type="text"
                                   class="form-control @error('name_exp') is-invalid @enderror"
                                   name="name_exp" value="{{ $expert->name_exp }}" required autocomplete="family-name"
                                   autofocus>

                            @error('name_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="firstname_exp" class="col-form-label">Firstname</label>

                            <input id="firstname_exp" type="text"
                                   class="form-control @error('firstname_exp') is-invalid @enderror"
                                   name="firstname_exp" value="{{ $expert->firstname_exp }}" required
                                   autocomplete="given-name" autofocus>

                            @error('firstname_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="sex_exp" class="col-form-label">Sex</label>

                            <select name="sex_exp" id="sex_exp" autocomplete="sex"
                                    class="form-control @error('sex_exp') is-invalid @enderror">
                                @foreach($listSexExpert as $sexExpert)
                                    @if($sexExpert == $expert->sex_exp)
                                        <option value="{{ $sexExpert }}" selected> {{ ucfirst($sexExpert) }}</option>
                                    @else
                                        <option value="{{ $sexExpert }}">{{ ucfirst($sexExpert) }}</option>
                                    @endif
                                @endforeach

                            </select>

                            @error('sex_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mail_exp" class="col-form-label">Email</label>

                            <input id="mail_exp" type="email"
                                   class="form-control @error('mail_exp') is-invalid @enderror"
                                   name="mail_exp" value="{{ $expert->mail_exp }}" required autocomplete="email">

                            @error('mail_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="type_exp" class="col-form-label">Type of expert</label>

                            <select name="type_exp" id="type_exp"
                                    class="form-control @error('type_exp') is-invalid @enderror">
                                @foreach($listTypeExpert as $TypeExpert)
                                    @if(session('expert')['type'] != 'superadmin' && $TypeExpert != 'superadmin'
                                        || session('expert')['type'] == 'superadmin')
                                        @if ($TypeExpert == $expert->type_exp)
                                            <option value="{{ $TypeExpert }}" selected>{{ ucfirst($TypeExpert) }}</option>
                                        @else
                                            <option value="{{ $TypeExpert }}">{{ ucfirst($TypeExpert) }}</option>
                                        @endif
                                    @endif
                                @endforeach

                            </select>

                            @error('type_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="bd_date_exp" class="col-form-label">Birth date</label>

                            <input id="bd_date_exp" type="date"
                                   class="form-control @error('bd_date_exp') is-invalid @enderror"
                                   name="bd_date_exp" value="{{ $expert->bd_date_exp }}" required autocomplete="bday">

                            @error('bd_date_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address_exp" class="col-form-label">Address</label>

                            <input id="address_exp" type="text"
                                   class="form-control @error('address_exp') is-invalid @enderror"
                                   name="address_exp" value="{{ $expert->address_exp }}" required
                                   autocomplete="street-address" autofocus>

                            @error('address_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="pc_exp" class="col-form-label">Postal code</label>

                            <input id="pc_exp" type="text" class="form-control @error('pc_exp') is-invalid @enderror"
                                   name="pc_exp" value="{{ $expert->pc_exp }}" required autocomplete="postal-code"
                                   autofocus>

                            @error('pc_exp')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="city_exp" class="col-form-label">City</label>

                            <input id="city_exp" type="text"
                                   class="form-control @error('city_exp') is-invalid @enderror"
                                   name="city_exp" value="{{ $expert->city_exp }}" required autofocus>

                            @error('city_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>


                        <div class="form-group">
                            <label for="tel_exp" class="col-form-label">Phone</label>

                            <input id="tel_exp" type="tel" class="form-control @error('tel_exp') is-invalid @enderror"
                                   name="tel_exp" value="{{ $expert->tel_exp }}" autocomplete="tel">

                            @error('tel_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pwd_exp" class="col-form-label">New password (optional)</label>

                            <input id="pwd_exp" type="password"
                                   class="form-control @error('pwd_exp') is-invalid @enderror" name="pwd_exp"
                                   autocomplete="new-password">

                            @error('pwd_exp')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="pwd_exp_confirmation" class="col-form-label">Confirm New Password</label>

                            <input id="pwd_exp_confirmation" type="password" class="form-control"
                                   name="pwd_exp_confirmation"
                                   autocomplete="new-password">

                            @error('pwd_exp_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>

                        @if(session('expert')['type'] == "expert")
                            <div class="form-group">
                                <label for="current_pwd_exp" class="col-form-label">Current Password</label>

                                <input id="current_pwd_exp" type="password" class="form-control @error('current_pwd_exp') is-invalid @enderror"
                                       name="current_pwd_exp"
                                       required autocomplete="new-password">

                                @error('current_pwd_exp')
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                                @enderror
                            </div>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    <button type="submit" class="form-control btn btn-primary">
                        Register
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
