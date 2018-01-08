<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
use DB;
use Log;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('organization.team.index', []);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $team = App\Team::findOrFail($id);

        $this->authorize('show', $team);

        $team_members = $team->users()
        ->select('team_id', 'users.id', 'users.name',
            'users.email', 'roles.name as role')
        ->join('roles','roles.id','=','role_id')
        ->get();

        // $others = $team->organization->users()
        // ->selectRaw("$id as team_id, users.id, users.name,
        //     users.email, 'Member' as role")
        // ->whereNotIn('id', $team_members->pluck('id')->toArray())
        // ->get();

        return view('organization.team.manage', [
            'team'=>$team,
            'members'=>$team_members,
            'other_org_members'=>json_encode(null),
            'mode'=>'show'
        ]);
    }

    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $team = App\Team::findOrFail($id);

        $this->authorize('update', $team);

        $team_members = $team->users()
        ->select('team_id', 'users.id', 'users.name',
            'users.email', 'roles.name as role')
        ->join('roles','roles.id','=','role_id')
        ->get();

        $others = $team->organization->users()
        ->selectRaw("$id as team_id, users.id, users.name,
            users.email, 'Member' as role")
        ->whereNotIn('id', $team_members->pluck('id')->toArray())
        ->get();

        return view('organization.team.manage', [
            'team'=>$team,
            'members'=>$team_members,
            'other_org_members'=>$others,
            'mode'=>'edit'
        ]);
    }

}
