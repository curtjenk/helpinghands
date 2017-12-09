<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
        App\Event::class => App\Policies\EventPolicy::class,
    ];

/*

['name'=>'Create organization'],
['name'=>'Delete organization'],
['name'=>'Show organization'],
['name'=>'Update organization'],
['name'=>'List organizations'],

['name'=>'Create team'],
['name'=>'Delete team'],
['name'=>'Show team'],
['name'=>'Update team'],
['name'=>'List teams'],

['name'=>'Create event'],
['name'=>'Delete event'],
['name'=>'Show event'],
['name'=>'Update event'],
['name'=>'List events'],

 */
    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('administer', function($user) {
            return $user->permissions()
                ->where('permissions.name', 'LIKE', "%Create%")
                ->count();
        });
        Gate::define('create-event', function ($user) {
            return $user->has_permission('Create event');
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
        Gate::define('send-evites', function ($user) {
            return true;
            return !$user->is_superuser() &&
                  ($user->is_admin() || $user->is_orgAdmin());
        });
    }
}
