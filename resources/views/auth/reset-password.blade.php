@extends('layouts.app')

@section('panel-heading')       
        <p class="text-center">Register Form</p>
@endsection

@section('content')
    <form action="{{ route('password-reset')}}" method="POST" autocomplete="off">
        {{csrf_field()}}
       
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
    
       
      
     


        <div class="form-group">
            
                <button type="submit" class="btn btn-success form-control">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    Submit New Password
                </button>
            
        </div>

    </form>

@endsection