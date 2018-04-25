@extends('layouts.app')

@section('panel-heading')
    Edit A Tag
@endsection
@section('content')
  <form action="{{  route('tags.update',$tag->name) }}" method="POST" >
        {{csrf_field()}}

         <div class="form-group">
            <label for="Tags"> Tag Name</label>
            <input type="text" name="name" class="form-control" placeholder="Edit Tag Name" value="{{ $tag->name }}">
        </div>
       

        <div class="form-group">
            <input type="hidden" name="_method" value="PUT">
            <input type="submit" value="Edit Tag" class="btn btn-primary">
        </div>
  </form>
 

@endsection