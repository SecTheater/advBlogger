<?php

namespace App;
use Cartalyst\Sentinel\Users\EloquentUser;
class User extends EloquentUser
{
	public function getRouteKeyName(){
		return 'username';
	}
	
	public function comments(){
		return $this->hasMany(Comment::class);
	}
	public function replies(){
		return $this->hasMany(Reply::class);
	}
	public function getSecurityQuestionAttribute($value){
		return $this->attributes['security_question'] = ucfirst(str_replace('_' , ' ' , $value));
	}
	

}
