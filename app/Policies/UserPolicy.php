<?php

namespace App\Policies;

use App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    /**
     * Return true if user can destroy this user.
     * It can't delete itself.
     *
     * @return boolean
     */
    public function destroy(User $self, User $user)
    {
        if ($self->id == $user->id) { return false; }
        if (!$self->has_permission('Delete user')) { return false; }
        if (!$self->is_admin()) {return false;}
        return true;
    }

    /**
     * Return true if user can show this user
     *
     * @return boolean
     */
    public function show(User $self, User $user)
    {
        return $self->has_permission('Show user')&&
        ($self->is_admin() || $self->organization_id == $user->organization_id);
    }

    /**
     * Return true if user can update this user
     *
     * @return boolean
     */
    public function update(User $self, User $user)
    {
        return $self->has_permission('Update user') &&
        ($self->id == $user->id ||  $self->is_admin());
    }
}
