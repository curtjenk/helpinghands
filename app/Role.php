<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
      * Get the Permissions for this Role
      */
    public function permissions()
    {
        return $this->belongsToMany('App\Permission');
    }
}
