<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'description', 'evite_sent', 'date_start', 'organization_id',
        'date_end', 'user_id', 'status_id', 'event_type_id'
    ];
    /**
     * Get the Organization for this Event.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
    /**
     * Get the User that created this .
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    /**
     * Get the status for this event
     */
    public function status()
    {
        return $this->belongsTo('App\Status');
    }
    /**
     * Get the type for this event
     */
    public function event_type()
    {
        return $this->belongsTo('App\EventType');
    }
    /**
     * Get users signedup for this event;
     */
    public function signups()
    {
        return App\User::select('users.*')
            ->join('responses', 'responses.user_id', '=', 'users.id')
            ->where('responses.event_id', $this->id)
            ->where('responses.helping',true)
            ->distinct();
    }
}
