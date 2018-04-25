<?php

namespace App\Http\Controllers\Auth;
use Hash;
use Sentinel;

use App\Http\Controllers\Controller;

class ChangePasswordController extends Controller
{
    function getChangePassword(){
    	return view('auth.change-password');
    }
    function postChangePassword(){
    	if(Sentinel::check()){
    		$user = \App\User::whereEmail(Sentinel::getUser()->email)->first();
    		if($user){
    			request()->validate([
    				'current_password' => 'required|min:8|max:32|string',
    				'password' => 'required|min:8|max:32|string|confirmed'
    			]);
    			// check the user password

    			if(Hash::check(request()->current_password,Sentinel::getUser()->password)){
    				$user->password = Hash::make(request()->password);
    				$user->save();
    				if (Sentinel::hasAnyAccess(['moderator.*','admin.*'])) {
    					return redirect()->route('admin.dashboard')->with('success','Password has been changed successfully');
    				}
    				return redirect()->home()->with('success','Password Has been changed successfully');
    			}else{
    				return redirect()->back()->with('error','Invalid Password');
    			}
    		}
    	}else{
    		return redirect()->route('login')->with('info','Perhaps you forgot to login');
    	}
    }
}
