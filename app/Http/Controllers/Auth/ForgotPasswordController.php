<?php

namespace App\Http\Controllers\Auth;
use Sentinel;
use Activation;
use Reminder;
use App\User;
use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ForgotPasswordController extends Controller
{
    public function postForgotPassword()
    {
    	//validation
    	request()->validate([
    		'email' => 'required|string'
    	]);
    	$user = User::whereUsernameOrEmail(request('email'),request('email'))->first();
    	if (count($user) === 0) {
    		return redirect()->route('login')->with('success','Reset Code Has Been sent to your email');
    	}
    	$user = Sentinel::findById($user->id);
    	if (Activation::completed($user)) {

    		$reminder = Reminder::exists($user) ?: Reminder::create($user);
    		$this->sendEmail($user,$reminder->code);
    		return redirect()->route('login')->with('success','Reset Code Has been sent to your account');
    	}else {
    		return redirect()->route('login')->with('error','Activate your account first');
    	}
    
    }
    private function sendEmail($user,$token)
    {
    	Mail::send('emails.forgot-password',['user' => $user ,'token' => $token ],function($message) use($user){
    		$message->to($user->email);
    		$message->subject("Reset Your Password");
    	});
    }
}
