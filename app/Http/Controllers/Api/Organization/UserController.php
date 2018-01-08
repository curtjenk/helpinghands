<?php

namespace App\Http\Controllers\Api\Organization;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\Inputs;
use Auth;
use App;
use DB;
use Log;

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
        // $user = Auth::user();
        $this->authorize('create-organization');
        $this->validate($request, [
            'auth_user_id' => 'required',
            'user_id' => 'required',
            'organization_id' => 'required',
        ]);
        $organization_id = $request->organization_id;
        $auth_user_id = $request->auth_user_id;
        $user_id = $request->user_id;

        $organization = App\Organization::findOrFail($organization_id);
        $user = App\User::findOrFail($user_id);
        if ($auth_user_id != Auth::user()->id) {
            abort(401);
        }
        $role_id = App\Role::where('name','Admin')->pluck('id')->first();
        DB::table('organization_user')->insert([
            'organization_id'=>$request->organization_id,
            'user_id'=>$request->user_id,
            'role_id'=>$role_id
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
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'auth_user_id' => 'required',
            'user_id' => 'required',
            'organization_id' => 'required',
        ]);
        $organization_id = $request->organization_id;
        $auth_user_id = $request->auth_user_id;
        $user_id = $request->user_id;

        $organization = App\Organization::findOrFail($organization_id);
        $user = App\User::findOrFail($user_id);
        if ($auth_user_id != Auth::user()->id) {
            abort(401);
        }
        $this->authorize('update', $organization);

        return;
    }

}
