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
    public function view(User $user, Organization $organization)
    {
        return $user->has_permission('Show organization')&&
        ($user->is_admin() || $user->organization_id == $organization->id);
    }
    public function show(User $user, Organization $organization)
    {
        return $this->view($user, $organization);
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
        return $user->has_permission('Update organization')&&
        ($user->is_admin() || $user->organization_id == $organization->id);
    }

    /**
     * Determine whether the user can delete the organization.
     *
     * @param  \App\User  $user
     * @param  \App\Organization  $organization
     * @return mixed
     */
     public function delete(User $user, Organization $organization)
     {
         return $user->has_permission('Delete organization')&&
         ($user->is_admin() || $user->organization_id == $organization->id);
     }
     public function destroy(User $user, Organization $organization)
     {
         return $this->delete($user, $organization);
     }
}
