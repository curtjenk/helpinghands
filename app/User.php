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
        'password', 'remember_token', 'pivot'
    ];
    public function getCanAttribute($type, $id, $perm){
        return true;
    }
    public function memberships()
    {
        // Log::debug("SuperUser ".$this->superuser());
        if ($this->superuser()) {
            return App\Organization::with(['teams']);
        } else {
            return App\Organization::with(['teams'])
                ->select('organizations.*', 'roles.name as role')
                ->where('organizations.name','!=','Ministry Engage')
                ->join('organization_user', 'organization_user.organization_id', '=', 'organizations.id')
                ->join('users', 'users.id', '=', 'organization_user.user_id')
                ->join('roles', 'roles.id', '=', 'organization_user.role_id')
                ->where('users.id', $this->id);
        }

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
            ->join('roles', 'roles.id', '=', 'organization_user.role_id')
            ->where('organization_user.user_id', $this->id)
            ->where('roles.name','!=', 'Visitor')
            ->count() == 0;
    }
    /**
     * Get list of users who are part of the same organization(s) as me
     * @return [type] [description]
     */
    public function peers($orgid=null, $teamid=null)
    {
        // return DB::table('users as u1')->select('users.*')
        return App\User::with(['organizations' => function($q) {
                $q->where('organizations.name','!=','Ministry Engage');
            }, 'organizations.teams'])
            ->from('users as u1')->select('users.*')
            ->join('organization_user as ou1', 'ou1.user_id','=','u1.id')
            ->join('organization_user as ou2','ou2.organization_id', '=','ou1.organization_id')
            ->join('organizations','organizations.id','=','ou2.organization_id')
            ->join('users', 'users.id', '=', 'ou2.user_id')
            ->when($orgid, function($q) use($orgid) {
                $q->where('ou2.organization_id', $orgid);
            })
            ->when($teamid, function($q) use($teamid) {
                $q->join('team_user','team_user.organization_id','=','ou2.organization_id')
                ->where('team_user.organization_id', $teamid);
            })
            ->where('u1.id', $this->id)
            ->where('organizations.name','!=','Ministry Engage')
            ->distinct();
    }
    /*
        Get list of permissions
     */
    public function permissions()
    {
        return $this->organization_permissions()->select('permissions.name')
            ->union($this->team_permissions()->select('permissions.name'));
    }
    public function organization_permissions()
    {
        return DB::table('permissions')
            ->select('organization_user.organization_id','permissions.*')
            ->join('permission_role','permission_role.permission_id','=','permissions.id')
            ->join('roles','roles.id','=','permission_role.role_id')
            ->join('organization_user','organization_user.role_id','=','roles.id')
            ->where('organization_user.user_id', $this->id)
            ->distinct();
    }
    public function team_permissions()
    {
        return DB::table('permissions')
            ->select('team_user.team_id','permissions.*')
            ->join('permission_role','permission_role.permission_id','=','permissions.id')
            ->join('roles','roles.id','=','permission_role.role_id')
            ->join('team_user','team_user.role_id','=','roles.id')
            ->where('team_user.user_id', $this->id)
            ->distinct();
    }
    /*
        Get list of roles
    */
    public function roles()
    {
        return $this->organization_roles()->select('roles.name')
            ->union($this->team_roles()->select('roles.name'));
    }

    public function organization_roles()
    {
        return DB::table('roles')
        ->select('organization_user.organization_id','roles.*')
        ->join('organization_user','organization_user.role_id','=','roles.id')
        ->where('organization_user.user_id', $this->id)
        ->distinct();
    }

    public function team_roles()
    {
        return DB::table('roles')
        ->select('team_user.team_id','roles.*')
        ->join('team_user','team_user.role_id','=','roles.id')
        ->where('team_user.user_id', $this->id)
        ->distinct();
    }

    public function has_permission($name, $orgid=null, $teamid=null)
    {
        $query = DB::table('permissions')
            ->join('permission_role','permission_role.permission_id','=','permissions.id')
            ->join('roles','roles.id','=','permission_role.role_id')
            ->join('organization_user','organization_user.role_id','=','roles.id')
            ->where('organization_user.user_id', $this->id)
            ->when(isset($orgid), function($q) use($orgid) {
                $q->where('organization_user.organization_id', $orgid)
                ->orWhere('roles.name','Site');
            })
            ->when(isset($teamid), function($q) use($teamid) {
                $q->join('team_user','team_user.role_id','=','roles.id')
                ->where('team_user.organization_id', $teamid)
                ->where('team_user.user_id', $this->id)
                ->orWhere('roles.name','Site');;
            })
            ->where('permissions.name', $name);

        // Log::debug($query->toSql());
        // Log::debug($query->getBindings());
        return $query->count() > 0;
    }
    /**
     * Check if the User has A Permission for any org or for a specific org.
     */
    public function has_org_permission($orgid, $name)
    {
        $query = DB::table('permissions')
            ->join('permission_role','permission_role.permission_id','=','permissions.id')
            ->join('roles','roles.id','=','permission_role.role_id')
            ->join('organization_user','organization_user.role_id','=','roles.id')
            ->where('organization_user.user_id', $this->id)
            ->where(function($q) use($orgid, $name){
                // $q->where(function($q) use($orgid, $name) {
                //     $q->where('permissions.name', $name)
                //     ->where('organization_user.organization_id', $orgid);
                // })
                $q->where(function($q) use($orgid, $name) {
                    $q->when(isset($orgid), function($q) use($orgid) {
                        $q->where('organization_user.organization_id', $orgid);
                    })
                    ->where('permissions.name', $name);
                })
                ->orWhere('roles.name','Site');
            });

        // Log::debug($query->toSql());
        // Log::debug($query->getBindings());
        return $query->count() > 0;
    }
    /**
     * Checks if A Permission for any team or for a specific team.
     * @param  [type]  $teamid [description]
     * @param  [type]  $name   name of the permission
     * @return boolean         [description]
     */
    public function has_team_permission($teamid, $name)
    {
        if ($this->superuser()) { return true; }

        $query = DB::table('permissions')
            ->join('permission_role','permission_role.permission_id','=','permissions.id')
            ->join('roles','roles.id','=','permission_role.role_id')
            ->join('team_user','team_user.role_id', '=','roles.id')
            ->where('team_user.user_id', $this->id)
            ->where(function($q) use($teamid, $name){
                $q->where(function($q) use($teamid, $name) {
                    $q->when(isset($teamid), function($q) use($teamid) {
                        $q->where('team_user.team_id', $teamid);
                    })
                    ->where('permissions.name', $name);
                })
                ->orWhere('roles.name','Site');
            });
            // Log::debug($query->toSql());
            // Log::debug($query->getBindings());

        return $query->count() > 0;
    }

    /**
     * Check if the User has a specific Organization role
     */
    // public function has_org_role($orgid, $name)
    // {
    //     // return true;
    //     return DB::table('organization_user')
    //         ->join('roles', 'roles.id', '=', 'organization_user.role_id')
    //         ->where('roles.name', $name)
    //         ->where('organization_user.organization_id', $orgid)
    //         ->where('organization_user.user_id', $this->id)
    //         ->orWhere('roles.name','Site')
    //         ->count() > 0;
    // }
    // public function has_team_role($orgid, $teamid, $name)
    // {
    //     // return true;
    //     return DB::table('organization_user')
    //         ->join('teams', 'teams.organization_id', '=', 'organization_user.organization_id')
    //         ->join('team_user', 'team_user.team_id', '=', 'teams.id')
    //         ->join('roles', 'roles.id', '=', 'team_user.role_id')
    //         ->where('roles.name', $name)
    //         ->where('organization_user.organization_id', $orgid)
    //         ->where('organization_user.user_id', $this->id)
    //         ->where('team_user.user_id', $this->id)
    //         ->where('team.id', $teamid)
    //         ->orWhere('roles.name','Site')
    //         ->count() > 0;
    // }
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
