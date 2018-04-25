<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
	protected $dates = [
		'approved_at'
	];
	public function getRouteKeyName(){
		return 'title';
	}
	public function comments(){
		return $this->hasMany(Comment::class);
	}
	public function tags(){
		return $this->belongsToMany(Tag::class,'post_tag','post_id','tag_id');
	}
	public function getCreatedAtAttribute($value){

		return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value)->diffForHumans();
	}
	public function getApprovedAtAttribute($value){
		
		return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$value)->diffForHumans();
	}
	public static function archives(){
		return static::selectRaw('year(created_at) year,monthname(created_at) month, count(*) published')
		->groupBy('year','month')
		->orderByDesc('year')
		->get()->toArray();
	}
	public function scopeFilter($query,$month = null,$year = null){
		if(isset($month)){
			$query->whereMonth('created_at',Carbon::parse($month)->month);
		}
		if(isset($year)){
			$query->whereYear('created_at',Carbon::parse($year)->year);
		}
	}



	public function admin(){
		return $this->belongsTo(Admin::class);
	}
	 public static function PopularPosts(){
        return Post::join('comments', 'comments.post_id', '=', 'posts.id')
            ->groupBy(['posts.id','posts.title'])
            ->get(['posts.id', 'posts.title', \DB::raw('count(posts.id) as post_count')])
            ->sortByDesc('post_count');
       
    }
	public static function listApproved(){
		return static::whereApproved(1)->orderByDesc('created_at');
	}
}
