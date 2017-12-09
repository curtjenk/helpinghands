<?php

namespace App\Policies;

use App\User;
use App\Organization;
use Illuminate\Auth\Access\HandlesAuthorization;

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
        return $self->superuser();
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
        return $self->superuser() ||
            $organization->users()
                ->where('organization_user.user_id',$user->id)
                ->count() > 0;
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
        // return $self->superuser() ||
        // $self->has_org_role($organization->id, 'Admin');
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
         return true;
        // return $self->superuser();
     }
}
