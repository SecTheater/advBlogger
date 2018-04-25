<div class="col-6 col-md-3 sidebar-offcanvas">
	@if (isset($archives))
		<ul class="list-group">
			<li class="list-group-item">Archives</li>
			@foreach ($archives as $stats)
				<li class="list-group-item"><a href="{{ route('archives',['month' => $stats['month'],'year' => $stats['year']]) }}"> {{ $stats['month'] . ' ' . $stats['year'] }}</a></li>
			@endforeach
		</ul>
	@endif
	
	@if (isset($tags))
		<ul class="list-group">
				<li class="list-group-item">Popular Tags</li>
				@foreach ($tags as $tag)
					<li class="list-group-item"><a href="{{ route('tags.show',$tag->name) }}"> {{ $tag->name }}</a></li>
				@endforeach
		</ul>
	@endif
	
	@if (Sentinel::getUser()->hasAccess('admin.*'))
		@if (isset($tags))
			<ul class="list-group">
				<li class="list-group-item">Your Own Tags</li>
					@foreach ($tags as $tag)
						<li class="list-group-item"><a href="{{ route('tags.show',$tag->name) }}"> {{ $tag->name }}</a></li>
					@endforeach
			</ul>
		@endif
		@if (isset($online_users))
			<ul class="list-group">
				<li class="list-group-item">Online Users</li>
				@foreach ($online_users as $user)
					<li class="list-group-item"><a href="/profile/{{$user->username}}"><span ><i class="fa fa-user fa-lg"></i></span> {{ $user->first_name . ' ' . $user->last_name }}</a>
						<div class="pull-right">
							<span ><i class="fa fa-circle" style="color:lightgreen"></i></span>
						</div>

					</li>
				@endforeach
			</ul>
		@endif
		
	
	@endif

</div>