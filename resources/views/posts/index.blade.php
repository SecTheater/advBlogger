@extends('layouts.app')
@section('panel-heading')
	<p class="text-center">All Posts</p>
@endsection
@section('content')
	@if (count($posts) > 0)
		@foreach ($posts as $post)
		
    
    <a href="/posts/{{ $post->title }}" style="text-decoration: none;opacity: .3"><img src="/images/{{ $post->imagePath }}" style="max-height: 125px;max-width: 125px;padding-left: 5px; border-radius: 50%"><h1>{{ $post->title }}</h1></a>
    <p> <small> By <a href="/profile/{{ $post->admin->username }}">{{ $post->admin->username }}</a></small></p>
    <p class="text-primary"> {{$post->body }}</p>
  
<span class="badge">Posted {{ $post->created_at }}</span>
@if ($post->updated_at != null)
<span class="badge">Edited At {{ $post->updated_at->diffForHumans() }}</span>


@endif
<div class="dropdown" style="margin: 15px 15px;">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Post Managing
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu">
                            @if ($post->approved === 0)
                                @if (Sentinel::getUser()->hasAccess('*.approve'))
                                    <li>
                                        <a href="{{ route('posts.approve',$post->id) }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('approve-form').submit();">
                                            Approve
                                        </a>

                                        <form id="approve-form" action="{{ route('posts.approve',$post->id) }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                @endif
                            @endif
                            @if (Sentinel::getUser()->hasAccess('*.delete'))
                                {{-- expr --}}
                                <li>
                                        <a href="{{ route('posts.destroy',$post->title) }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('destroy-form').submit();">
                                            Delete
                                        </a>

                                        <form id="destroy-form" action="{{ route('posts.destroy',$post->title) }}" method="POST" style="display: none;">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            
                                        </form>
                                    </li>
                            @endif
                            @if (Sentinel::getUser()->hasAccess('*.edit'))
                                <li>
                                        <a href="{{ route('posts.edit',$post->title) }}">
                                        Edit
                                        </a>

                                        
                                    </li>
                            @endif
                        </ul>
                    </div>
<div class="pull-right" style="margin:bottom:5px;">
@foreach ($post->tags as $tag)
<span class="label label-primary"><a href="/tags/{{$tag->name }}" style="color:black;hover:none;text-decoration: none;">{{ $tag->name}}</a></span>
  {{-- expr --}}
@endforeach

                    
               
</div>              

			{{-- expr --}}
<hr style="margin-bottom:15px;border: ">
		@endforeach
	@else
		<div class="jumbotron">
		 There is no posts to show	
			
		</div>
	@endif
@endsection