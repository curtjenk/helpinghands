<?php

namespace App\Policies;

use App\User;
use App\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;

class OrganizationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the organization.
     *
     * @param  \App\User  $user
     * @param  \App\Organization  $organization
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->has_org_permission($organization->id, 'Create organization');
    }
    /**
     * Determine whether the user can view the organization.
     *
     * @param  \App\User  $user
     * @param  \App\Organization  $organization
     * @return mixed
     */
    public function show(User $user, Organization $organization)
    {
        return $user->has_permission('Show organization', $organization->id);
    }
    /**
     * Determine whether the user can update the organization.
     *
     * @param  \App\User  $user
     * @param  \App\Organization  $organization
     * @return mixed
     */
    public function update(User $user, Organization $organization)
    {
        return $user->has_org_permission($organization->id, 'Update organization');
    }

    /**
     * Determine whether the user can delete the organization.
     *
     * @param  \App\User  $user
     * @param  \App\Organization  $organization
     * @return mixed
     */
     public function destroy(User $user, Organization $organization)
     {
        return $user->has_org_permission($organization->id, 'Delete organization');
     }
}
