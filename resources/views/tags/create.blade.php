@extends('layouts.app')

@section('panel-heading')
    Create A Tag
@endsection
@section('content')
  <form action="{{ route('tags.store') }}" method="POST">
        {{csrf_field()}}
        <div class="form-group">
            <label for="title"> Name</label>
            <input type="text" name="name" class="form-control" placeholder="name" value="{{ old('name')}}">
        </div>
        
        <div class="form-group">
            <input type="submit" value="Release Tag" class="btn btn-primary">
        </div>
  </form>
 

@endsection