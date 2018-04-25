@component('mail::message')
# Email Activation

Hello {{ $user->first_name}},
We are glad that you are here, Let's hope you enjoy the website
in order to complete the process of activation
please click the button below
@component('mail::button', ['url' => env('APP_URL','http://localhost:8000') . '/activate/'. $user->email . '/' . $token])
Activate Account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
