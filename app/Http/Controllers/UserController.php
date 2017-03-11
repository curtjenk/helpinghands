<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('list-users');
        $user = Auth::user();

        $query=App\User::with('organization')
            ->where('role_id', '!=', 1)
            ->where('role_id', '>=', $user->role_id)
            ->where('users.id', '!=', $user->id)
            ->when(!$user->is_admin(), function($q) use($user) {
                return $q->where('organization_id', $user->organization_id);
            })
            ->get();

        return view('user.index', [
                'users'=>$query,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-user');
        $user = Auth::user();

        $roles = App\Role::where('id', ">=", $user->role_id)->get();

        if ($user->role->name == 'Organization Admin') {
            $orgs = App\Organization::where($user->organization_id)->get();
        } else {
            $orgs = App\Organization::all();
        }
        return view('user.create',
            ['organizations'=>$orgs,
             'roles'=>$roles]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create-user');
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'organization_id' => 'required|exists:organization,id',
            'role_id' => 'required|exists:roles,id',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //dump("here");
        $user = App\User::findOrFail($id);
        $this->authorize('show',$user);
        return view('user.show', [
            'user'=>$user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $self = Auth::user();
        $user = App\User::findOrFail($id);
        $this->authorize('update', $user);

        return view('user.edit', [
            'user'=>$user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|max:255|min:5',
            'mobilephone' => 'max:255',
            'homephone' => 'max:255',
            //'new_password' => 'confirmed|required_with:old_password',
        ]);
        $user = App\User::findOrFail($id);
        $self = Auth::user();
        $this->authorize('update', $user);
        $user->name = $request->input('name');
        $user->mobilephone = $request->input('mobilephone');
        $user->homephone = $request->input('homephone');
        $user->save();
        return redirect('/user/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            // dump("here = $id");
        $user = App\User::findOrFail($id);
        $this->authorize('destroy', $user);

        $user->delete();
        return redirect('/user');
    }
}
