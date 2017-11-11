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
        'password', 'remember_token'
    ];

    public function memberships()
    {
        return App\User::with('organizations.teams')
            ->where('id',$this->id)
            ->first()
            ->organizations;
    }
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

    public function superuser()
    {
        return DB::table('organization_user')
            ->join('roles', 'roles.id', '=', 'organization_user.role_id')
            ->where('organization_user.user_id', $this->id)
            ->where('roles.name', 'Site')
            ->count() > 0;
    }
    public function visitor()
    {
        return DB::table('organization_user')
            ->where('organization_user.user_id', $this->id)
            ->count() == 0;
    }
    /**
     * Get list of users who are part of the same organization(s) as me
     * @return [type] [description]
     */
    public function peers()
    {
        return DB::table('users as u1')->select('users.*')
            ->join('organization_user as ou1', 'ou1.user_id','=','u1.id')
            ->join('organization_user as ou2','ou2.organization_id', '=','ou1.organization_id')
            ->join('users', 'users.id', '=', 'ou2.user_id')
            ->where('u1.id', $this->id)
            ->distinct();

    }
    // /**
    //  * Check if the User has a specific Organization Permission
    //  */
    public function has_org_role($orgid, $name)
    {
        // return true;
        return DB::table('organization_user')
            ->join('roles', 'roles.id', '=', 'organization_user.role_id')
            ->where('roles.name', $name)
            ->where('organization_user.organization_id', $orgid)
            ->where('organization_user.user_id', $this->id)
            ->count() > 0;
    }
    public function has_team_role($orgid, $teamid, $name)
    {
        // return true;
        return DB::table('organization_user')
            ->join('teams', 'teams.organization_id', '=', 'organization_user.organization_id')
            ->join('team_user', 'team_user.team_id', '=', 'teams.id')
            ->join('roles', 'roles.id', '=', 'team_user.role_id')
            ->where('roles.name', $name)
            ->where('organization_user.organization_id', $orgid)
            ->where('organization_user.user_id', $this->id)
            ->where('team_user.user_id', $this->id)
            ->where('team.id', $teamid)
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
