@extends('layouts.app')

@section('panel-heading')
	Upgrade Users
@endsection
@section('content')
	<ul class="list-group">
		@if ($users != NULL)
			{{-- expr --}}
		@foreach ($users as $user)
			<li class="list-group-item" style="height:350px">
				{{ $user->username }} : {{ $user->roles->first()->name }} <br />
				Real Permissions : 
				<ul class="list-group">
					@foreach ($user->roles->first()->permissions as $permission => $value)
						@if ($value)
							
						<li class="list-group-item"> {{$permission .'=>' . 'true'}}</li>
						@else
							<li class="list-group-item"> {{$permission .'=>' . 'false'}}</li>

						@endif
					@endforeach
					@if($user->permissions != NULL)
						Updated Permissions : <br />
						@foreach ($user->permissions as $permission => $value)
						@if ($value)
						<li class="list-group-item"> {{$permission .'=>' . 'true'}}</li>
						@else
							<li class="list-group-item"> {{$permission .'=>' . 'false'}}</li>

						@endif
						@endforeach
					@endif
				</ul>
				
				<div class="pull-right">
					<form action="{{ route('upgrade.users',$user->username) }}" method="POST">
						{{csrf_field()}}
						Show :<input type="checkbox" name="list[]" value="show">
						Create : <input type="checkbox" name="list[]" value="create">
						Edit :<input type="checkbox" name="list[]" value="edit">
						Delete :<input type="checkbox" name="list[]" value="delete">
						Approve :<input type="checkbox" name="list[]" value="approve">
						Permission Level
						<select name="permission_level" class="form-control">
							<option value="admin">Adminstrator</option>	
							<option value="moderator">Moderator</option>	
							<option value="user">Normal User</option>	
						</select>
						<input type="submit" value="Upgrade User">
					</form>
					
				</div>
			</li>
		@endforeach
		@else
			<p class="text-center">No users to upgrade</p>
		@endif
	</ul>
@endsection