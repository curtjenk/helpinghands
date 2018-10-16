<?php

namespace App\Policies;

use App\User;
use App\Team;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;

class TeamPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can
     *
     * @param  \App\User  $user
     * @param  \App\Team  $team
     * @return mixed
     */
    // public function create(User $user)
    // {
    //     return $user->has_org_permission($team->organization->id, 'Update Organization');
    //     // return $user->has_org_permission($organization->id, 'Create organization');
    // }
    /**
     * Determine whether the user can v
     *
     * @param  \App\User  $user
     * @param  \App\Team  $team
     * @return mixed
     */
    public function show(User $user, Team $team)
    {
        $a = $user->has_team_permission($team->id, 'Show team');
        $b = $user->has_org_permission($team->organization->id, 'Show organization');
        $c = $user->superuser();
            Log::debug('orgid '.$team->organization->id.' f1 '.$a);
            Log::debug('f2 '.$b);
            Log::debug('f3 '.$c);
        return $a || $b || $c;
    }
    /**
     * Determine whether the user can update the organization.
     *
     * @param  \App\User  $user
     * @param  \App\Team  $team
     * @return mixed
     */
    public function update(User $user, Team $team)
    {
        $a = $user->has_team_permission($team->id, 'Update team');
        $b = $user->has_org_permission($team->organization->id, 'Update organization');
        $c = $user->superuser();
        return $a || $b || $c;
    }

    /**
     * Determine whether the user can delete the organization.
     *
     * @param  \App\User  $user
     * @param  \App\Team  $organization
     * @return mixed
     */
     public function destroy(User $user, Team $team)
     {
         $a = $user->has_team_permission($team->id, 'Delete team');
         $b = $user->has_org_permission($team->organization->id, 'Update organization');
         $c = $user->superuser();
         return $a || $b || $c;
     }
}
