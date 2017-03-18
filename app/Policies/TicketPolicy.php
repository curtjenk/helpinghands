<?php

namespace App\Policies;

use App\User;
use App\Ticket;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function view(User $user, Ticket $ticket)
    {
        return $user->has_permission('Show ticket')&&
        ($user->is_admin() || $user->organization_id == $tcket->organization_id);
    }
    public function show(User $user, Ticket $ticket)
    {
        return $this->view($user, $ticket);
    }


    /**
     * Determine whether the user can update the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function update(User $user, Ticket $ticket)
    {
        return $user->has_permission('Update ticket')&&
        ($user->is_admin() || $user->organization_id == $ticket->organization_id);
    }

    /**
     * Determine whether the user can delete the ticket.
     *
     * @param  \App\User  $user
     * @param  \App\Ticket  $ticket
     * @return mixed
     */
    public function delete(User $user, Ticket $ticket)
    {
        return $user->has_permission('Delete ticket')&&
        ($user->is_admin() || $user->organization_id == $tcket->organization_id);
    }
    public function destroy(User $user, Ticket $ticket)
    {
        return $this->delete($user, $ticket);
    }
}
