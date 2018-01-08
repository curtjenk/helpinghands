<?php

namespace App\Http\Controllers\Api\Organization;

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
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $organization = App\Organization::findOrFail($request->organization_id);
        $this->authorize('update', $organization);
        $role = App\Role::where('name','Admin')->first();
        $this->update_role($request, $organization, $role);
        return;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $organization = App\Organization::findOrFail($request->organization_id);
        $this->authorize('update', $organization);
        $role = App\Role::where('name','Member')->first();
        $this->update_role($request, $organization, $role);
        return;
    }

    private function update_role($request, $organization, $role)
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
        DB::table('organization_user')
            ->where('organization_id', $organization->id)
            ->where('user_id',$org_user->id)
            ->update(['role_id'=>$role->id]);
    }

}
