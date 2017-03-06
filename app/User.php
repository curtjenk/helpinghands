<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if the User has a specific Permission
     */
    public function has_permission($name, $multipayer)
    {
        return DB::table('permission_role')
                ->join('permissions', 'permission_role.permission_id', '=',
                       'permissions.id')
                ->where('permission_role.role_id', $this->role_id)
                ->where('permissions.name', $name)
                ->count() > 0;
    }
}
