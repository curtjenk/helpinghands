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
    // public function show($id)
    // {
    //     $user = Auth::user();
    //     if ($user->superuser()) {
    //     }
    //     $organization = App\Organization::with(['teams','teams.users'])
    //     ->where('id', $id)
    //     ->first();
    //
    //     $orgmembers = $organization->users()
    //     ->select('organization_id', 'users.id as user_id', 'users.name as name','roles.name as role_name')
    //     ->join('roles','roles.id','=','role_id')
    //     ->get();
    //
    //     $this->authorize('show', $organization);
    //
    //     return view('organization.manage', [
    //         'organization'=>$organization,
    //         'members'=>$orgmembers,
    //         'mode'=>'show'
    //     ]);
    // }
    //
    // /**
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function edit($id)
    {
        $team = App\Team::with('users')->findOrFail($id);
        $this->authorize('update', $team);
        $orgmembers = $team->organization->users()
        ->select('organization_id', 'users.id as user_id', 'users.name as name','roles.name as role_name')
        ->join('roles','roles.id','=','role_id')
        ->get();
        return view('organization.team.manage', [
            'team'=>$team,
            'members'=>$orgmembers,
            'mode'=>'edit'
        ]);
    }

}
