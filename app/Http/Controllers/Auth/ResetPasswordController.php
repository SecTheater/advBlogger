<?php 
namespace App\Http\Controllers\Auth;
use Sentinel;
use Reminder;
use Activation;
use Mail;
use \App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ResetPasswordController extends Controller
{
	//reset/email/token
	function getPasswordResetThroughEmail($email,$token){
		$user = User::whereEmail($email)->first();
		if($user){
			$user = Sentinel::findById($user->id);

			if(Reminder::exists($user)->code === $token){
				\Session::put('user',$user);
				\Session::put('token',$token);
				return view('auth.reset-password');
			}else{
				return redirect()->route('login')->with('error','Invalid Token');
			}
		}else{
			return redirect()->route('login')->with('error','Email Does not exist');
		}
	}
	function postPasswordResetThroughEmail(){
		request()->validate([
			'password' => 'required|min:8|max:32|confirmed'
		]);
		if($reminder = Reminder::complete(\Session::get('user'),\Session::get('token'),request('password'))){
			Reminder::removeExpired();
			\Session::flush();
			return redirect()->route('login')->with('success','Password Has been changed successfully');
		}else{
			return redirect()->route('login')->with('error','Please Try again later');
		}
	}
	function getPasswordResetThroughQuestion(){
		\Session::flash('info','Do not refresh while the process else you will start all over again');
		return view('auth.resetByQuestion');

	}
	function postPasswordResetThroughQuestion1(){
		// dob,location,email
		request()->validate([
			'dob' => 'required|date|before_or_equal:2000-01-01',
			'location' => 'required|string|min:3|max:32|exists:users,location',
			'email' => 'required|email|exists:users,email'
		]);
		$user = \App\User::whereEmail(request('email'))->first();
		if(\Activation::completed($user)){
			$user = \App\User::where(['email' => request('email'),'location' => request('location') ,'dob' => request('dob')])->first();
			if($user){
				\Session::put('user',$user);
				\Session::flash('success','Stage 2 : answering the security question');
				return redirect()->back()->with('question' , $user->security_question);
			}else{
				return redirect()->back()->with('error','Invalid Data');
			}
		}else{
			return redirect()->back()->with('error','Account is not activated yet');
		}
	}
	function postPasswordResetThroughQuestion2(){
		request()->validate([
			'sec_question' => 'required|string|in:where_are_you_from,what_is_your_hobby,what_is_your_favorite_car,who_is_your_favorite_doctor_or_teacher',
			'sec_answer' => [
				'required',
				'min:2',
				'max:32',
				'regex:/^[a-zA-Z0-9 ]*$/',
				'string'
			]
		]);
		if(\Session::exists('user')){
			$user = User::where([
				'email' => \Session::get('user')->email ,
				'dob' => \Session::get('user')->dob,
				'location' => \Session::get('user')->location,
				'security_question' => request('sec_question'),
				'security_answer' => request('sec_answer') 
			])->first();
			if($user){
				return redirect()->back()->with(['success' => 'Stage 3 : submit new password' , 'stage 3' => 'This is a stage 3']);
			}else{
				\Session::flush();
				return redirect()->back()->with('error','Invalid Data');
			}
		}
	}
	function postPasswordResetThroughQuestion3(){
		request()->validate([
			'password' => 'string|required|min:8|max:32|confirmed'
		]);
		if(\Session::exists('user')) {
			$user = User::where(['email' => \Session::get('user')->email , 'security_answer' => \Session::get('user')->security_answer])->first();
			if($user){
				$user->password = bcrypt(request('password'));
				$user->save();
				\Session::flush();
				return redirect()->route('login')->with('success', 'PAssword has been changed successfully');
			}else{
				\Session::flush();
				return redirect()->back()->with('error','Invalid Data');
			}
		}
		\Session::flush();
		return redirect()->back()->with('error','Invalid Data');

	}
}