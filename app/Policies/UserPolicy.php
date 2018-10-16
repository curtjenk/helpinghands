<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Log;

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
        return $self->superuser();
    }

    /**
     * Return true if user can show this user
     *
     * @return boolean
     */
    public function show(User $self, User $user)
    {
        return true;
    }

    /**
     * Return true if user can update this user
     *
     * @return boolean
     */
    public function update(User $self, User $user)
    {
        if ($self->id == $user->id) {
            return true;
        }

        foreach ($user->organizations as $org) {
            if ($self->has_permission('Update user', $org->id)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return true if user can create a user
     *
     * @return boolean
     */
    public function create(User $self)
    {
        return $self->superuser();
    }
}
