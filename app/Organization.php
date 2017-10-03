<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'address1', 'address2', 'city',
        'state', 'zipcode',
    ];

    public function events()
    {
        return $this->hasMany('App\Event');
    }

    public function parent()
    {
        return $this->belongsTo('App\Organization', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Organization', 'parent_id');
    }
    public function teams()
    {
        return $this->hasMany('App\Team');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
