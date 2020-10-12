@extends('layouts.layout')

@section('content')
<div class="row">
    <div class="col"></div>
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h5 class="m-0 font-weight-bold text-primary">Profile</h5>
            </div>
            <div class="card-body">
                @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {!! session('error') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {!! session('success') !!}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
                <form method="POST" action="{{route('profile.update', Auth::user()->id)}}">
                    @csrf
                    {{ method_field('PUT') }}
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{Auth::user()->name}}" {{$errors->has('name') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('name')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" value="{{Auth::user()->username}}" {{$errors->has('username') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('username')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{Auth::user()->email}}" {{$errors->has('email') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('email')}}</p>
                    </div>
                    <p class="text-secondary"><strong><i>**Fill password only when change password</i></strong> <br> <small><i>password min. 8 char</i></small></p>
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input id="current_password" type="password" class="form-control" name="current_password" autocomplete="current_password" {{$errors->has('current_password') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('current_password')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="new_password">New Password</label>
                        <input id="new_password" type="password" class="form-control" name="new_password"  autocomplete="new_password" {{$errors->has('new_password') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('new_password')}}</p>
                    </div>
                    <div class="form-group">
                        <label for="new_confirm_password">Confirm Password</label>
                        <input id="new_confirm_password" type="password" class="form-control" name="new_confirm_password"  autocomplete="new_password" {{$errors->has('new_confirm_password') ? 'is-invalid' : ''}}>
                        <p class="text-danger">{{$errors->first('new_confirm_password')}}</p>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                    <button type="reset" class="btn btn-danger" username="reset">Reset</button>
                    <a type="button" href="{{url()->previous()}}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col"></div>
</div>
@endsection
