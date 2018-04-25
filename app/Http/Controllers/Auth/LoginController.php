<?php

namespace App\Http\Controllers\Auth;
use Sentinel;
use Illuminate\Http\Request;
use Cartalyst\Sentinel\Checkpoints\{NotActivatedException,ThrottlingException};
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function getLogin(){
    	return view('auth.login');
    }
    public function postLogin(){

        request()->validate([
            'email' => new \App\Rules\usernameOrEmail,
            'password' => 'required|string|min:8|max:32',
            'remember' => 'in:on,null'
           
        ],['remember.in' => 'Invalid Value']);
        $remember = false;
        if(request('remember') === 'on'){
            $remember = true;
        }
        
      
      
            try {
                $user = Sentinel::authenticate(['login' => request('email'), 'password' => request('password')],$remember);
                if($user){
                    if($user->hasAnyAccess(['admin.*','moderator.*'])){
                        return redirect()->route('admin.dashboard')->with('success','Welcome to the admin dashboard');
                    }elseif($user->hasAccess('user.*')){
                        return redirect()->home()->with('success','Logged in Successfully');
                    }
                    
                }
             
                return redirect()->back()->with('error','Invalid Credentials');
                
            } catch (NotActivatedException $e) {
                return redirect()->back()->with('error','Perhaps you forgot to activate your account');
            }catch(ThrottlingException $e){
                return redirect()->back()->with('error', $e->getMessage());
            }
            
       
       
    }
    public function logout(){
    	Sentinel::logout(null,true);
    	return redirect()->route('login')->with('success','Come back again whenever you can ');
    }
}
