<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Auth;
use Log;

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
                $user = Auth::check() ? Auth::user() : null;
                if (!empty($user)) {
                    $roles = $user->roles()->get()->pluck('name');
                    $permissions = $user->permissions()->get()->pluck('name');
                } else {
                    $roles = [];
                    $permissions = [];
                }

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
