<h1>Hello {{ $user->first_name }}</h1>

Click Here to reset your password
<p>
	
	<a href="{{ env('APP_URL','http://localhost:8000'.'/reset/'.$user->email.'/'. $token)}}">Reset Your Password</a>
</p>