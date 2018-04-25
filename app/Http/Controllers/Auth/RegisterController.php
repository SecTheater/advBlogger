<?php

namespace App\Http\Controllers\Auth;
use Mail;
use \App\Mail\Activation as UserActivation;
use Sentinel;
use Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
   public function getRegister(){
   	return view('auth.register');
   }
   public function postRegister(){
  
		request()->validate([
			'email' => 'required|unique:users,email|email',
			'username' => 'required|min:6|max:18|alpha_dash|unique:users,username',
			'first_name' => 'required|min:3|max:18|alpha',
			'last_name' => 'required|min:3|max:18|alpha',
			'location' => [
				'regex:/^[a-zA-Z0-9-_. ]*$/','required','min:3','max:20'
			],
			'password' => 'required|string|min:8|max:32|confirmed',
			'dob' => 'required|date|before_or_equal:2000-01-01|date_format:Y-m-d',
			'sec_question' => 'required|string|in:where_are_you_from,what_is_your_hobby,what_is_your_favorite_car,who_is_your_favorite_doctor_or_teacher',
			'sec_answer' => [
				'required','min:4','max:32','regex:/^[a-zA-Z0-9 ]*$/',
				'string'
			]

		]);

		$user = Sentinel::register([
			'email' => request()->email,
			'username' => request()->username,
			'first_name' => request()->first_name,
			'last_name' => request()->last_name,
			'location' => request()->location,
			'password' => request()->password,
			'dob' => request()->dob,
			'security_question' => request()->sec_question,
			'security_answer' => request()->sec_answer
		]);
      $user = Sentinel::findById($user->id);
      $activation = Activation::create($user);
      
   	Mail::to($user)->send(new UserActivation($user,$activation));
    $role = Sentinel::findRoleBySlug('user');
    $role->users()->attach($user);
     
   	return redirect()->route('login')->with('success','Registered Successfully, Activate your account');
   }
  
}
