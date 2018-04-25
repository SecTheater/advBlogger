<?php

namespace App\Http\Controllers;
use Sentinel;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
	function getProfile($username){
		$user = \App\User::whereUsername($username)->first();
		if($user){
			return view('user.profile')->with('user',$user);
			
		}
		if(Sentinel::hasAnyAccess(['admin.*','moderator.*'])){
			return redirect()->route('admin.dashboard')->with('error','Invalid Profile Name');
		}
		return redirect()->route('user.dashboard')->with('error','Invalid Profile Name');
	}
	function postProfile(){
		$user = Sentinel::getUser();
		request()->validate([
			'email' => "nullable|email|unique:users,email,$user->id",
			'username' => "nullable|string|min:3|max:32|unique:users,username,$user->username",
			'location' => 'nullable|string|min:3|max:32',
			'dob' => 'nullable|before_or_equal:2000-01-01',
			'profile_picture' => 'nullable|max:1999|image|mimes:jpg,jpeg,png',
			'first_name' => 'string|nullable|min:3|max:32',
			'last_name' => 'string|nullable|min:3|max:32',
			'password' => 'string|required|min:8|max:32'
		]);
		if(Hash::check(request('password'),$user->password)){
			if(request()->hasFile('profile_picture')){
				$file_with_ext = request()->file('profile_picture')->getClientOriginalName();
				$file_ext = request()->file('profile_picture')->getClientOriginalExtension();
				$file_name_new = str_random(40) . time() . '.' . $file_ext;
				$path = request()->file('profile_picture')->move(public_path(). '/profile_pictures/',$file_name_new);
			}
			$user->email = request('email') ?? $user->email;
			$user->username = request('username') ?? $user->username;
			$user->location = request('location') ?? $user->location;
			$user->dob	= request('dob') ?? $user->dob;
			$user->first_name = request('first_name') ?? $user->first_name;
			$user->last_name = request('last_name') ?? $user->last_name;
			$user->profile_picture = $file_name_new ?? $user->profile_picture;
			$user->save();
			if($user->hasAnyAccess(['admin.*','moderator.*'])){
				return redirect()->route('admin.dashboard')->with('success','Profile Updated');
			}
			return redirect()->route('user.dashboard')->with('success','Profile Updated');
		}else{
			return redirect()->back()->with('error','Invalid Password');
		}
		
	}
}
