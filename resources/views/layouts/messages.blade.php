@if (count($errors) > 0)
	@foreach ($errors->all() as $error)
		<div class="alert alert-danger">
			<p class="text-center">
				{{ $error}}
			</p>
		</div>
		{{-- expr --}}
	@endforeach
@endif
@if (session('success'))
	<div class="alert alert-success">
		<p class="text-center"><i class="fa fa-check-square fa-lg" aria-hidden="true"></i>
			{{ session('success')}}
		</p>
	</div>
@endif

@if (session('error'))
	<div class="alert alert-danger">
		<p class="text-center"><i class="fa fa-exclamation-triangle fa-lg" aria-hidden="true"></i>
			{{ session('error')}}
		</p>
	</div>


@endif

@if (session('info'))
	<div class="alert alert-info">
		<p class="text-center"><i class="fa fa-exclamation fa-lg" aria-hidden="true"></i>
			{{ session('info')}}
		</p>
	</div>


@endif

