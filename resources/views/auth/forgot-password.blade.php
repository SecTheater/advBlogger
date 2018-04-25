@extends('layouts.app')
@section('panel-heading')
    <h4 class="text-center">Login Form</h4>
@endsection
@section('content')

    <form class="form-horizontal" method="POST" action="{{ route('reset') }}">
        {{ csrf_field() }}

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label for="email" class="col-md-4 control-label">E-Mail Address | Username</label>

            <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-envelope fa-lg"></i></span>
                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
        </div>

       

        

        <div class="form-group">
            <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                    Send Email
                </button>
               
        
            </div>
        </div>
    </form>
                
         
@endsection
