<?php

namespace App\Policies;

use App\User;
use App\Event;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the .
     *
     * @param  \App\User  $user
     * @param  \App\Event  $event
     * @return mixed
     */
    public function view(User $user, Event $event)
    {
        return $user->has_permission('Show event')&&
        ($user->is_admin() || $user->organization_id == $event->organization_id);
    }
    public function show(User $user, Event $event)
    {
        return $this->view($user, $event);
    }


    /**
     * Determine whether the user can update the .
     *
     * @param  \App\User  $user
     * @param  \App\Event  $
     * @return mixed
     */
    public function update(User $user, Event $event)
    {
        return $user->has_permission('Update event')&&
        ($user->is_admin() || $user->organization_id == $event->organization_id);
    }

    /**
     * Determine whether the user can delete the .
     *
     * @param  \App\User  $user
     * @param  \App\Event  $
     * @return mixed
     */
    public function delete(User $user, Event $event)
    {
        return $user->has_permission('Delete event')&&
        ($user->is_admin() || $user->organization_id == $event->organization_id);
    }
    public function destroy(User $user, Event $event)
    {
        return $this->delete($user, $event);
    }
}
