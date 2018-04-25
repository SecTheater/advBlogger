<?php 

Route::get('/archives/{month}/{year}','PostController@getByArchive')->name('archives');
Route::group(['namespace' => 'Auth'],function(){
	Route::group(['middleware' => 'guest'],function(){
		Route::get('/register',[
			'uses' => 'RegisterController@getRegister',
			'as' => 'register'
		]);
		Route::post('/register',[
			'uses' => 'RegisterController@postRegister',
			'as' => 'register'
		]);
		Route::get('/login',[
			'uses' => 'LoginController@getLogin',
			'as' => 'login'
		]);
		Route::post('/login',[
			'uses' => 'LoginController@postLogin',
			'as' => 'login'
		]);
	
		Route::get('/activate/{email}/{token}','EmailActivationController@activateUser');
		Route::get('/reset','ForgotPasswordController@getForgotPassword')->name('reset');
		Route::post('/reset','ForgotPasswordController@postForgotPassword')->name('reset');
		Route::get('/reset/{email}/{token}','ResetPasswordController@getPasswordResetThroughEmail')->name('forgot.password');
		Route::post('/reset-password','ResetPasswordController@postPasswordResetThroughEmail')->name('password-reset');
		Route::get('/resetBySecurityQuestion' , ['uses' => 'ResetPasswordController@getPasswordResetThroughQuestion','as' => 'reset.security']);
		Route::post('/resetBySecurityQuestion/stage1' , ['uses' => 'ResetPasswordController@postPasswordResetThroughQuestion1','as' => 'reset.security1']);
		Route::post('/resetBySecurityQuestion/stage2' , ['uses' => 'ResetPasswordController@postPasswordResetThroughQuestion2','as' => 'reset.security2']);
		Route::post('/resetBySecurityQuestion/stage3' , ['uses' => 'ResetPasswordController@postPasswordResetThroughQuestion3','as' => 'reset.security3']);
	});

	
	Route::group(['middleware' => 'admin'],function(){
		Route::get('/admin',function(){
			return view('admin.dashboard');
		})->name('admin.dashboard');
		Route::get('/change-password',[
		'uses' => 'ChangePasswordController@getChangePassword',
		'as' => 'change-password'
	]);
	Route::post('/change-password',[
		'uses' => 'ChangePasswordController@postChangePassword',
		'as' => 'change-password'
	]);


	});
	Route::post('logout',[
		'uses' => 'LoginController@logout',
		'as' => 'logout',
		'middleware' => 'user:admin'
	]);	
	
});
Route::group(['middleware' => 'user:admin'],function(){
	Route::get('/profile/{username}',['uses' => 'UserController@getProfile','as' =>'profile']);
	Route::post('/profile',['uses' => 'UserController@postProfile','as' => 'profile']);
});
	Route::group(['middleware' => 'admin'],function(){

		Route::get('/upgrade','AdminController@listUsers')->name('list.users');
		Route::get('/downgrade','AdminController@listUsers');
		Route::post('/downgrade/{username}','AdminController@downgradeUser')->name('downgrade.users');
		Route::post('/upgrade/{username}','AdminController@upgradeUser')->name('upgrade.users');
		Route::get('/posts/unapproved',['uses' => 'PostController@listUnApproved','as' => 'posts.unapproved'])->middleware('admin');
		Route::post('/posts/approve/{id}',['uses' => 'AdminController@approvePost','as' =>'posts.approve'])->middleware('admin');
		Route::resource('/posts','PostController');
		Route::resource('/tags','TagController');
		Route::get('/popular/tags','TagController@sortByPopularity');
	});
Route::get('/comments','CommentController@index')->name('comments.index');
Route::get('/comments/{comment}','CommentController@show')->name('comments.show');
Route::get('/comments/{comment}/{post}','CommentController@edit')->name('comments.edit');
Route::post('/comments/{post}','CommentController@store')->name('comments.store');
Route::put('/comments/{comment}/','CommentController@update')->name('comments.update');
Route::delete('/comments/{comment}','CommentController@destroy')->name('comments.destroy');
Route::get('/replies/{reply}','RepliesController@show')->name('replies.show');
Route::get('/replies/{reply}/{post}','RepliesController@edit')->name('replies.edit');
Route::post('/replies/{comment}/{post}','RepliesController@store')->name('replies.store');
Route::put('/replies/{reply}/{comment}/{post}','RepliesController@update')->name('replies.update');
Route::delete('/replies/{reply}','RepliesController@destroy')->name('replies.destroy');

Route::get('/home',function(){
	return view('home');
})->name('home')->middleware('user');

Route::get('/test',function(){
	// foreach (\App\Tag::latest()->take(3)->get() as $tag) {
	// 	$tag->update(['name' => 'css']);
	// }
	dd(\App\Admin::userTags('john_doe'));
	$reply = new \App\Reply;
	dd($reply->find(3)->comment);
	dd(\App\Tag::PopularTags());
	dd(\App\Post::orderByDesc('created_at')->whereApproved(1)->comments);
});