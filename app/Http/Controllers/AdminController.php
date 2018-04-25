<?php

namespace App\Http\Controllers;
use \App\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
	public function approvePost($id){
		if(Admin::approve($id)){
			return redirect()->route('posts.index')->with('success','Post Has been Approved Successfully');
		}
		return redirect()->route('posts.index')->with('error','Failed to approve the post');
	}
	public function listUsers(){
		if(request()->path() === 'upgrade')
		return view('admin.upgrade')->with('users',Admin::listUsers());
			
		return view('admin.downgrade')->with('users',Admin::listUsers());
		
	}
	public function upgradeUser(\App\User $username){
		request()->validate([
			'list' => 'required|array',
			'list.*' => 'string|min:4|max:7|in:show,create,edit,delete,approve',
			'permission_level' => 'string|in:admin,moderator,user'
		],['list.*' => 'Invalid Option']);

		foreach (array_values(request()->list) as $value) {
			
			if(!$username->hasAnyAccess(request('permission_level') . $value)){
				// user,admin,moderator
				$permissions[request('permission_level'). '.' .$value] = true;
			}
			continue;
		}
		if(Admin::upgradeUser($username->id,$permissions)){
			return redirect()->back()->with('success','User Upgraded!');
		}
		return redirect()->back()->with('error','User could not be upgraded');
	}

	public function downgradeUser(\App\User $username){
		request()->validate([
			'list' => 'required|array',
			'list.*' => 'string|min:4|max:7|in:show,create,edit,delete,approve',
			'permission_level' => 'string|in:admin,moderator,user'
		],['list.*' => 'Invalid Option']);

		foreach (array_values(request()->list) as $value) {
			
			if($username->hasAnyAccess([ request('permission_level') . $value])){
				$permissions[request('permission_level'). '.' .$value] = false;
			}
			continue;
			
		}
		if(Admin::downgradeUser($username->id,$permissions)){
			return redirect()->back()->with('success','user Downgraded!');
		}
		return redirect()->back()->with('error','User could not be Downgraded !');

	}
	
}
