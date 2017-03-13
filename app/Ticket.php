<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
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
     * Get the Organization for this ticket.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }
    /**
     * Get the User that created this ticket.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
