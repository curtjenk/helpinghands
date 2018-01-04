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
    public function create(User $user)
    {
        return true;
        // return $user->has_org_permission($organization->id, 'Create organization');
    }
    /**
     * Determine whether the user can v
     *
     * @param  \App\User  $user
     * @param  \App\Team  $team
     * @return mixed
     */
    public function show(User $user, Team $team)
    {
        return $user->has_team_permission($team->id, 'Show Team');
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
        return $user->has_team_permission($team->id, 'Update team');
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
        return $user->has_org_permission($team->id, 'Delete team');
     }
}
