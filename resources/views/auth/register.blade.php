@extends('layouts.app')

@section('panel-heading')       
        <p class="text-center">Register Form</p>
@endsection

@section('content')
    <form action="{{ route('register')}}" method="POST" autocomplete="off">
        {{csrf_field()}}
        <div class="form-group">
                <label for="Email"> Email </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                <input type="email" class="form-control" required placeholder="example@example.com" name="email" value="{{ old('email') }}">
            </div>
        </div>
        <div class="form-group">
                        <label for="username"> Username </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Ex : User_name" name="username" value="{{ old('username')}}" required>
            </div>

        <div class="form-group">
                        <label for="first_name"> First Name </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="John" name="first_name" value="{{ old('first_name')}}" required>
            </div>
        </div>
        <div class="form-group">
        <label for="last_name"> Last Name </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                <input type="text" class="form-control" placeholder="Doe" name="last_name" value="{{ old('last_name')}}" required>
            </div>
        </div>

        <div class="form-group">
        <label for="Location"> Location </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="United States" name="location" value="{{ old('location')}}" required>
            </div>
        </div>
        <div class="form-group">
        <label for="Password"> Password </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="Password" name="password" required>
            </div>
        </div>
        <div class="form-group">
        <label for="password_confirmation"> Password Confirmation </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="password" class="form-control" placeholder="Password Confirmation" name="password_confirmation" required>
            </div>
        </div>
        <div class="form-group">
        <label for="sec_question"> Security Question </label>
            <select class="form-control" name="sec_question">
              <option selected disabled>Pick Up A Question</option>
                <option value="who_is_your_favorite_doctor_or_teacher">Who is your favorite Doctor Or Teacher ?</option>
              <option value="where_are_you_from">Where Are you from?</option>
              <option value="what_is_your_hobby">What is your hobby?</option>
              <option value="what_is_your_favorite_car">What is your favorite car ?</option>
            </select>
        </div>
        <div class="form-group">
        <label for="sec_answer"> Answer The Question</label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                <input type="text" class="form-control" placeholder="Answer The Question" name="sec_answer" required value="{{ old('sec_answer') }}">
            </div>
        </div>
        <div class="form-group">
        <label for="dob"> Date Of Birth </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-birthday-cake"></i></span>
                <input type="date" class="form-control" name="dob" required value="{{ old('dob') }}">

            </div>
        </div>
       
      
     


        <div class="form-group">
            
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    Register
                </button>
                <p class="text-center">Already A member ?<small><a href="{{ route('login') }}"> Login</a></small></p>        

            
        </div>

    </form>

@endsection