<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Auth;

class UserRolesPermissionsProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function ($view)
        {
            // if(!$view->offsetExists('userRolesPermissions'))
            // {
                $user=Auth::check() ? Auth::user() : null;
                $roles=Auth::check() ? Auth::user()->roles()->get()->pluck('name') : [];
                $permissions=Auth::check() ? Auth::user()->permissions()->get()->pluck('name') : [];

                $view->with('userRolesPermissions', [
                    'user'=>$user,
                    'roles'=>$roles,
                    'permissions'=>$permissions]
                );
            // }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
