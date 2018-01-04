<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App;

class Team extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'organization_id', 'name', 'description'
    ];

    protected $hidden = ['pivot'];

    /**
     * Get the Organization for this Team.
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
     * Get the Team members.
     */
    public function users()
    {
        return $this->belongsToMany('App\User')->withPivot('role_id');
    }

}
