<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Organization' => 'App\Policies\OrganizationPolicy',
        'App\Ticket' => 'App\Policies\TicketPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('create-ticket', function ($user) {
            return $user->has_permission('Create ticket');
        });
        Gate::define('list-tickets', function ($user) {
            return $user->has_permission('List tickets');
        });

        Gate::define('create-organization', function ($user) {
            return $user->has_permission('Create organization');
        });
        Gate::define('list-organizations', function ($user) {
            return $user->has_permission('List organizations');
        });

        Gate::define('create-user', function ($user) {
            return $user->has_permission('Create user');
        });
        Gate::define('list-users', function ($user) {
            return $user->has_permission('List users');
        });
    }
}
