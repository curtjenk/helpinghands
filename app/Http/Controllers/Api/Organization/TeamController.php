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
 *
 */
class TeamController extends Controller
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
        $this->validate($request, [
            'auth_user_id' => 'required',
            'name' => 'required',
            'description' => 'required',
        ]);

        if ($request->auth_user_id != Auth::user()->id) {
            abort(401);
        }

        $team = App\Team::create([
            'organization_id'=>$organization->id,
            'name'=>$request->name,
            'description'=>$request->description,
            'updated_user_id'=>$request->auth_user_id,
        ]);

        return response()->json(['id'=>$team->id]);
    }

    /**
     * Delete team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $organization = App\Organization::findOrFail($request->organization_id);
        $team = App\Team::findOrFail($request->team_id);
        $this->authorize('update', $organization);
        $this->authorize('destroy', $team);
        $this->validate($request, [
            'auth_user_id' => 'required',
        ]);

        if ($request->auth_user_id != Auth::user()->id) {
            abort(401);
        }
        $team->delete();
    }

}
