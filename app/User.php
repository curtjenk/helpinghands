<?php

namespace App;

use App;
use AddPermissions;
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
        'name', 'email', 'password',
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

    public function organizations()
    {
        return $this->belongsToMany('App\Organization');
    }

    public function teams()
    {
        return $this->belongsToMany('App\Team');
    }

    public function signedup($event_id, $helping='yes')
    {
        $helping = $helping=='yes' ? true : false;
        return $this->responses()
            ->where('event_id',$event_id)
            ->where('helping', $helping)
            ->count()>0;
    }

    public function responses()
    {
        return $this->hasMany('App\Response');
    }
    /**
     * Get the Organization for this user.
     */
    // public function organization()
    // {
    //     return $this->belongsTo('App\Organization');
    // }

    /**
     * Get the Role for this user.
     */
    // public function role()
    // {
    //     return $this->belongsTo('App\Role');
    // }

    // /**
    //  * Get the Roles for this user.
    //  */
    // public function roles()
    // {
    //     return $this->belongsToMany('App\Role');
    // }

    // /**
    //  * Check if the User has a specific Organization Permission
    //  */
    public function has_org_permission($orgid, $name)
    {
        // return true;
        return DB::table('organization_user')
            ->join('roles', 'roles.id', '=', 'organization_user.role_id')
            ->join('permission_role', 'permission_role.role_id', '=', 'roles.id')
            ->join('permissions', 'permission_role.permission_id', '=',
                       'permissions.id')
            ->where('permissions.name', $name)
            ->where('organization_user.organization_id', $orgid)
            ->where('organization_user.user_id', $this->id)
            ->count() > 0;
    }
    // /**
    //  * Check if the user has any administrative right
    //  * across all organizations
    //  */
    // public function is_admin()
    // {
    //     return true;
    //     // return DB::table('roles')
    //     //     ->where('id', $this->role_id)
    //     //     ->whereIn('name', ['Admin'])
    //     //     ->count() > 0;
    // }
    //
    // /**
    //  * System level user.
    //  * @return boolean [description]
    //  */
    // public function is_superuser()
    // {
    //     return DB::table('roles')
    //         ->where('id', $this->role_id)
    //         ->whereIn('name', ['Super User'])
    //         ->count() > 0;
    // }
    //
    // /**
    //  * Member of an organization whether the org's Admin or normal user
    //  * @return boolean [description]
    //  */
    // public function is_orgLevel()
    // {
    //     return DB::table('roles')
    //         ->where('id', $this->role_id)
    //         ->whereIn('name', ['Organization Admin', 'Organization User'])
    //         ->count() > 0;
    // }
    // /**
    //  * Admin of an organization
    //  * @return boolean [description]
    //  */
    // public function is_orgAdmin()
    // {
    //     return DB::table('roles')
    //         ->where('id', $this->role_id)
    //         ->where('name', 'Organization Admin')
    //         ->count() > 0;
    // }
    //
    // public function allowed_roles()
    // {
    //
    // }
}
