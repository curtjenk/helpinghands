<?php

namespace App\Http\Controllers\Api\Organization\Team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\Inputs;
use Auth;
use App;
use DB;
use Log;

/**
 * Updates the user's role within the organization.  Either "Admin" or "Member"
 */
class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     * Make user a team Lead.  Implies he/she is already a member
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store_lead(Request $request)
    {
        $team = App\Team::findOrFail($request->team_id);
        $this->authorize('update', $team);
        $role = App\Role::where('name','Lead')->first();
        $this->update_role($request, $team, $role);
        return;
    }

    // Make user a member of the team
    public function store_member(Request $request)
    {
        $team = App\Team::findOrFail($request->team_id);
        $user = App\User::findOrFail($request->user_id);
        $this->authorize('update', $team);
        $role = App\Role::where('name','Member')->first();
        $team_user = DB::table('team_user')
            ->where('team_id',$team->id)
            ->where('user_id',$user->id)
            ->first();
        if (isset($team_user)) {
            abort(400, "Already a member of the team");
        }
        DB::table('team_user')->insert([
            "team_id"=>$team->id,
            "user_id"=>$user->id,
            "role_id"=>$role->id
        ]);

        return;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_lead(Request $request)
    {
        $team = App\Organization::findOrFail($request->team_id);
        $this->authorize('update', $team);
        $role = App\Role::where('name','Member')->first();
        $this->update_role($request, $team, $role);
        return;
    }

    //Remove user from the team
    public function destroy_member(Request $request)
    {
        $team = App\Team::findOrFail($request->team_id);
        $user = App\User::findOrFail($request->user_id);
        $this->authorize('update', $team);

        $team_user = DB::table('team_user')
            ->where('team_id',$team->id)
            ->where('user_id',$user->id)
            ->first();
        if (!isset($team_user)) {
            abort(400, "Not a member of the team");
        }
        DB::table('team_user')->where([
            "team_id"=>$team->id,
            "user_id"=>$user->id,
        ])->delete();

        return;
    }

    private function update_role($request, $team, $role)
    {
        $this->validate($request, [
            'auth_user_id' => 'required',
            'user_id' => 'required',
        ]);

        $auth_user_id = $request->auth_user_id;
        if ($auth_user_id != Auth::user()->id) {
            abort(401);
        }

        $org_user = App\User::findOrFail($request->user_id);
        DB::table('team_user')
            ->where('team_id', $team->id)
            ->where('user_id',$org_user->id)
            ->update(['role_id'=>$role->id]);
    }

}
