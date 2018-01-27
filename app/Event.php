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
        'subject', 'description', 'description_text', 'evite_sent',
        'date_start', 'date_end', 'time_start', 'time_end',
        'organization_id', 'team_id',
        'user_id', 'status_id', 'event_type_id',
        'cost', 'signup_limit'
    ];
    /**
     * Get the Files/Attachments for this Event.
     */
    public function files()
    {
        return $this->hasMany('App\EventFiles');
    }
    /**
     * Get the Organization for this Event.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
    /**
     * Get the Team for this Event.
     */
    public function team()
    {
        return $this->belongsTo('App\Team');
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
    public function statusOpen()
    {
        return $this->status_id == 1 ? true : false;
    }
    public function statusClosed()
    {
        return $this->status_id == 2 ? true : false;
    }
    public function statusHold()
    {
        return $this->status_id == 3 ? true : false;
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

        return App\User::select('users.*', 'responses.paid as paid')
            ->join('responses', 'responses.user_id', '=', 'users.id')
            ->where('responses.event_id', $this->id)
            ->where('responses.helping',true)
            ->distinct();
    }
}
