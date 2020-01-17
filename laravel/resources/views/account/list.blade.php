@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-3 position-sticky">
                <form method="GET">
                    <div class="form-group">
                        <input type="text" id="name_exp" class="form-control" name="name_exp"
                               placeholder="search by last name"
                               value="{{ isset($_GET['name_exp']) && trim($_GET['name_exp']) ? trim($_GET['name_exp']) : '' }}">
                    </div>

                    <div class="form-group">
                        <input type="text" id="firstname_exp" class="form-control" name="firstname_exp"
                               placeholder="search by first name"
                               value="{{ isset($_GET['firstname_exp']) && trim($_GET['firstname_exp']) ? trim($_GET['firstname_exp']) : '' }}">
                    </div>

                    <div class="form-group">
                        <input type="text" id="mail_exp" class="form-control" name="mail_exp"
                               placeholder="search by email"
                               value="{{ isset($_GET['mail_exp']) && trim($_GET['mail_exp']) ? trim($_GET['mail_exp']) : '' }}">
                    </div>

                    @if(session('expert')['type'] == 'superadmin')
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="type[]" id="superadmin"
                                   value="superadmin" <?= isset($_GET['type']) && in_array('superadmin', $_GET['type']) ? 'checked' : '' ?> >
                            <label class="form-check-label" for="superadmin">Superadmin</label> <br>
                        </div>
                    @endif

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="type[]" id="admin" value="admin"
                        <?= isset($_GET['type']) && in_array('admin', $_GET['type']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="admin">Admin</label><br>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="type[]" id="expert"
                               value="expert" <?= isset($_GET['type']) && in_array('expert', $_GET['type']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="expert">Expert</label><br>
                    </div>
                    <div class="my-1">
                        <button type="submit" id="send-search" class="btn btn-primary">Rechercher</button>
                    </div>
                </form>
            </div>

            <div class="col-lg-9">
                @if(session('warning'))
                    <div class="alert alert-warning" role="alert">
                        {{ session('warning') }}
                    </div>
                @endif
                @foreach ($experts as $type => $experts)
                    <div class="mb-5">
                        <h3>{{ ucfirst($type) }} </h3>
                        <div class="table-responsive">
                            <table class='table table-hover'>
                                <thead>
                                <tr>
                                    <th scope='col'>Last name</th>
                                    <th scope='col'>First name</th>
                                    <th scope='col'>Mail</th>
                                </tr>
                                </thead>

                                @foreach($experts as $expert)
                                    <tr @if(($expert->type_exp == "expert" && $expert->id_exp == session('expert')['id'])
                                        || (session('expert')['type'] == "admin" && ($expert->type_exp == "expert" || $expert->id_exp == session('expert')['id']))
                                        || session('expert')['type'] == "superadmin")
                                        class="pointer"
                                        onclick="document.location = '{{ route('account.read', ['id' => $expert->id_exp]) }}'"
                                            @endif>

                                        <td>{{ $expert->name_exp }}</td>
                                        <td>{{ $expert->firstname_exp }}</td>
                                        <td>{{ $expert->mail_exp }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                    </div>

                @endforeach

            </div>
        </div>
    </div>

@endsection

