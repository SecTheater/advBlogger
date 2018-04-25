<?php

namespace App\Http\Controllers\Auth;

use Sentinel;
use \App\User;
use Activation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmailActivationController extends Controller
{
   public function activateUser($email,$token){
   		if($user = User::whereEmail($email)->first()){
   			$user = Sentinel::findById($user->id);
   			if(Activation::exists($user)){
   				if(Activation::complete($user,$token)){
   					Activation::removeExpired();
   					if(Sentinel::login($user,true)){
	   					return redirect()->home()->with('success','Logged in Successfully');
   						
   					}
   				}
   			}else{
   				return redirect()->route('login')->with('error','Invalid token');
   			}
   		}else{
   			return redirect()->route('login')->with('Invalid Email');
   		}
   }
}
