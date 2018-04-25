@extends('layouts.app')

@section('panel-heading')       
        @php
            $profile_picture = $user->profile_picture ?? 'default.png';

        @endphp
        <p class="text-center"><img src="{{ asset("profile_pictures/$profile_picture") }}" style="max-width: 50px;max-height:50px;border-radius: 50% "> {{ $user->first_name . ' ' . $user->last_name. '\'s ' }} Profile</p>
@endsection

@section('content')
@if (Sentinel::getUser()->id === $user->id)
    <form action="{{ route('profile')}}" method="POST" autocomplete="off" enctype="multipart/form-data">
        {{csrf_field()}}
        <div class="form-group">
                <label for="Email"> Email </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control"  placeholder="example@example.com" name="email" value="{{ $user->email }}">
            </div>
        </div>
        <div class="form-group">
                        <label for="username"> Username </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Ex : User_name" name="username" value="{{ $user->username}}" >
            </div>

        <div class="form-group">
                        <label for="first_name"> First Name </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="John" name="first_name" value="{{ $user->first_name }}" >
            </div>
        </div>
        <div class="form-group">
        <label for="last_name"> Last Name </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Doe" name="last_name" value="{{ $user->last_name }}" >
            </div>
        </div>

        <div class="form-group">
        <label for="Location"> Location </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="United States" name="location" value="{{ $user->location }}" >
            </div>
        </div>
        
        <div class="form-group">
        <label for="dob"> Date Of Birth </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                <input type="date" class="form-control" name="dob"  value="{{$user->dob}}">

            </div>
        </div>
        <div class="form-group">
            <label for="Update_Profile"> Update Profile Picture</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-upload fa-lg"></i></span>
                <input type="file" name="profile_picture" class="btn btn-default">
            </div>
        </div>
       
      
        <div class="form-group">
        <label for="Password"> Type Your Password To Verify It's you </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="Password" name="password" required="">
            </div>
        </div>
     


        <div class="form-group">
            
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    Update Profile
                </button>
            
        </div>

    </form>
@else
    <ul class="list-group-item">
        <li class="list-group-item"> Name:: {{ $user->username }}</li>
    </ul>
@endif

@endsection