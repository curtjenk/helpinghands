<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject', 'description', 'evite_sent', 'date_start', 'organization_id',
        'date_end', 'user_id',
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
}
