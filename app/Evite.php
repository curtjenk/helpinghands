<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Evite extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id', 'organization_id', 'team_id', 'user_id', 'num_invitations'
    ];

    /**
     * Get the Event for this Evite.
     */
    public function event()
    {
        return $this->belongsTo('App\Event');
    }
    
    /**
     * Get the User that created this Evite.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
