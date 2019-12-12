@extends('layouts.app')

@section('content')

    @if(session('expert')['id'] == $expert->id_exp)
        <h3 class="d-flex justify-content-center m-4">Your Account</h3>
    @endif
    <div class="d-flex justify-content-center">
        <div class="card">
            <div class="card-header text-uppercase">
                {{$expert->type_exp}}
            </div>
            <div class="card-body">
                <h5 class="card-title"></h5>
                <p class="card-text">First name : {{$expert->name_exp}}</p>
                <p class="card-text">First name : {{$expert->firstname_exp}}</p>
                <p class="card-text">Birth Date : {{$expert->bd_date_exp}}</p>
                <p class="card-text">Genre : {{$expert->sex_exp}}</p>
                <p class="card-text">Address : {{$expert->address_exp}}</p>
                <p class="card-text">CP : {{$expert->pc_exp}}</p>
                <p class="card-text">Mail : {{$expert->mail_exp}}</p>
                <p class="card-text">Mobile phone : {{$expert->tel_exp}}</p>
                <p class="card-text">City : {{$expert->city_exp}}</p>
            </div>
        </div>
    </div>

    <div class="text-center mt-3">
        <a href="{{ route('account.update', ['id' => $expert->id_exp]) }}" class="btn btn-primary">Update</a>

        @if($expert->type_exp != 'superadmin')
            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete">
                Delete account
            </button>
        @endif
    </div>


    <!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="{{ route('account.delete', ['id' => $expert->id_exp]) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection
