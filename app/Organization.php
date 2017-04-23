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
}
