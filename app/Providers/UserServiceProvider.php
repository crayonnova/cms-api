<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    
    public function boot()
    {

    }
    public function register()
    {
        $this->app->bind('App\Repositories\User\UserInterface','App\Repositories\User\UserRepository');
    }
}
