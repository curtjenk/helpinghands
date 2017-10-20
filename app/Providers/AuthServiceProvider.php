<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        App\User::class => App\Policies\UserPolicy::class,
        App\Organization::class => App\Policies\OrganizationPolicy::class,
        App\Event::class => App\Policies\EventPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('create-event', function ($user) {
            return $user->has_permission('Create event');
        });


        Gate::define('create-organization', function ($user) {
            return $user->has_permission('Create organization');
        });
        
        Gate::define('create-user', function ($user) {
            return $user->has_permission('Create user');
        });
        Gate::define('list-users', function ($user) {
            return $user->has_permission('List users');
        });
        Gate::define('send-evites', function ($user) {
            return !$user->is_superuser() &&
                  ($user->is_admin() || $user->is_orgAdmin());
        });
    }
}
