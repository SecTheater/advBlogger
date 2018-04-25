@extends('layouts.app')
@section('panel-heading')
	Tags
@endsection

@section('content')
	@if (count($tags) > 0)
		<ul class="list-group">
		@foreach ($tags as $tag)
		<li class="list-group-item"><a href="{{ route('tags.show',$tag->name) }}">{{ $tag->name }}</a></li>
		@endforeach
			
		</ul>
	@endif
@endsection