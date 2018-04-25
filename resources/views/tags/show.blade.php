@extends('layouts.app')
@section('panel-heading')
	<p class="text-center">{{ $tag->posts->count() . ' Posts have ' . strtoupper($tag->name) . ' Tag'}}</p>
@endsection

@section('content')
	@if (count($tag->posts) > 0)
		@foreach ($tag->posts as $post)
		<ul class="list-group">
		<li class="list-group-item"><a href="/posts/{{$post->title}}">{{$post->title}}</a></li>
		<li class="list-group-item">{{$post->body}}</li>
		<li class="list-group-item">{{$post->admin->username}}</li>

		</ul>
		@endforeach
			
	@endif
@endsection