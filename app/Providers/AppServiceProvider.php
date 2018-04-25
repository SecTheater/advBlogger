<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Schema::defaultStringLength(191);
       view()->composer('layouts.sidebar',function($view){
            if(!in_array('guest',request()->route()->middleware())){
                $view->with(['archives' => \App\Post::archives() , 'tags' => \App\Tag::PopularTags(),'adminTags' => \App\Admin::adminTags(\Sentinel::getUser()->username)]);
            }
            if (in_array('admin',request()->route()->middleware())) {
                $view->with(['online_users' => \App\Admin::listOnlineUsers()]);

            }
       });
      
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
