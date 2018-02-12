<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models;
use App;
use Log;

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
        App\Team::class => App\Policies\TeamPolicy::class,
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

        Gate::define('administer', function($user) {
            $okRole = $user->roles()->get()->contains(function($value, $key) {
                return $value->name == 'Admin' || $value->name == 'Lead'
                    || $value->name == 'Site';
            });
            // Log::debug($okRole);
            return $okRole;
        });

        Gate::define('create-event', function ($user) {
            return $user->has_permission('Create event');
        });
        Gate::define('list-events', function ($user) {
            return $user->has_permission('List events');
        });

        Gate::define('create-organization', function ($user) {
            return $user->has_permission('Create organization');
        });
        Gate::define('list-organizations', function ($user) {
            return $user->has_permission('List organizations');
        });
        Gate::define('manage-organization', function ($user) {
            return $user->has_org_permission(null, 'Create organization')
                || $user->has_org_permission(null, 'Update organization')
                || $user->has_org_permission(null, 'Delete organization');
        });


        Gate::define('create-team', function ($user) {
            return $user->has_permission('Create team');
        });
        Gate::define('manage-team', function ($user) {
            return $user->has_org_permission(null, 'Update organization')
                || $user->has_team_permission(null, 'Update team')
                || $user->has_team_permission(null, 'Delete team');
        });

        Gate::define('create-user', function ($user) {
            return $user->has_permission('Create user');
        });
        Gate::define('list-users', function ($user) {
            return $user->has_permission('List users');
        });

        Gate::define('send-evites', function ($user) {
            return true;
            return !$user->is_superuser() &&
                  ($user->is_admin() || $user->is_orgAdmin());
        });
    }
}
