<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;
use Auth;
use Log;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'organization_id',
        'mobilephone', 'homephone', 'opt_receive_evite', 'opt_show_mobilephone',
        'opt_show_homephone', 'opt_show_email',
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['authUserCanView', 'authUserCanDelete','authUserCanUpdate'];

    public function getAuthUserCanViewAttribute()
    {
        return Auth::user()->has_permission('Show user');
    }
    public function getAuthUserCanUpdateAttribute()
    {
        return Auth::user()->has_permission('Update user');
    }
    public function getAuthUserCanDeleteAttribute()
    {
        return Auth::user()->has_permission('Delete user');
    }

    public function signedup($event_id)
    {
        return $this->responses()
            ->where('event_id',$event_id)
            ->where('helping',true)
            ->count()>0;
    }

    public function responses()
    {
        return $this->hasMany('App\Response');
    }
    /**
     * Get the Organization for this user.
     */
    public function organization()
    {
        return $this->belongsTo('App\Organization');
    }

    /**
     * Get the Role for this user.
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }
    /**
     * Check if the User has a specific Permission
     */
    public function has_permission($name)
    {
        return DB::table('permission_role')
                ->join('permissions', 'permission_role.permission_id', '=',
                       'permissions.id')
                ->where('permission_role.role_id', $this->role_id)
                ->where('permissions.name', $name)
                ->count() > 0;
    }
    /**
     * Check if the user has any administrative right.
     */
    public function is_admin()
    {
        return DB::table('roles')
            ->where('id', $this->role_id)
            ->whereIn('name', ['Admin'])
            ->count() > 0;
    }

    public function is_superuser()
    {
        return DB::table('roles')
            ->where('id', $this->role_id)
            ->whereIn('name', ['Super User'])
            ->count() > 0;
    }

    public function is_orgLevel()
    {
        return DB::table('roles')
            ->where('id', $this->role_id)
            ->whereIn('name', ['Organization Admin', 'Organization User'])
            ->count() > 0;
    }
    public function is_orgAdmin()
    {
        return DB::table('roles')
            ->where('id', $this->role_id)
            ->where('name', 'Organization Admin')
            ->count() > 0;
    }
}
