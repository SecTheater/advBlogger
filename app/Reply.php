<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $table = 'replies';
	protected $fillable = ['body'];
	public function post(){
		return $this->belongsTo(Post::class);
	}
	public function comment(){
		return $this->belongsTo(Comment::class);
	}
	public function user(){
		return $this->belongsTo(User::class);
	}
}
