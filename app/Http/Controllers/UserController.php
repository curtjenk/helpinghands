<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\Inputs;
use App;
use Auth;
use Log;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function members(Request $request)
    {
        $this->authorize('list-users');
        $user = Auth::user();
        if (!$request->ajax()) {
            return view('user.memberslist', []);
        }
        Log::debug('here1');
        $inputs = new Inputs($request,
            ['orderby'=>'name',
             'direction'=>'asc',
             ]
        );
        Log::debug('here2');
        $query=App\User::with('organization')
            ->where('role_id', '!=', 1)
            ->where('role_id', '>=', $user->role_id)
            ->where('users.id', '!=', $user->id)
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organization_id', $user->organization_id);
            })->get();
        Log::debug('here3');
        Log::debug($query->count());
        return response()->json($query);
    }

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
            ->when($user->is_orgLevel(), function($q) use($user) {
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

        $roles = App\Role::where('roles.id', '>=', $user->role_id)->get();
        $orgs = App\Organization::select('organizations.*')
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organizations.id', $user->organization_id);
            })
            ->get();

        return view('user.create',
            ['orgs'=>$orgs,
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
            'mobilephone' => 'max:255',
            'homephone' => 'max:255',
            'organization_id' => 'required|exists:organizations,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        $newuser = App\User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'mobilephone'=>$request->input('mobilephone'),
            'homephone'=>$request->input('homephone'),
            'organization_id'=>$request->input('organization_id'),
            'role_id'=>$request->input('role_id')
        ]);
        return view('user.show', [
            'user'=>$newuser,
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
        $roles = App\Role::where('roles.id', '>=', $self->role_id)
            ->where('roles.name', '!=', 'Super User')
            ->get();
        $orgs = App\Organization::select('organizations.*')
            ->when($self->is_orgLevel(), function($q) use($self) {
                return $q->where('organizations.id', $self->organization_id);
            })
            ->get();

        return view('user.edit', [
            'user'=>$user,
            'roles'=>$roles,
            'orgs'=>$orgs
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
        //dump($request->all());
        $this->validate($request, [
            'name' => 'required|max:255|min:5',
            'mobilephone' => 'max:255',
            'homephone' => 'max:255',
            'org_id' => 'required|exists:organizations,id',
            'role_id' => 'required|exists:roles,id',
            //'new_password' => 'confirmed|required_with:old_password',
        ]);
        $user = App\User::findOrFail($id);
        $self = Auth::user();
        $this->authorize('update', $user);
        $user->name = $request->input('name');
        $user->mobilephone = $request->input('mobilephone');
        $user->homephone = $request->input('homephone');
        $user->organization_id = $request->input('org_id');
        $user->role_id = $request->input('role_id');
        $user->opt_receive_evite = $request->has('opt_receive_evite') ? true : false;
        $user->opt_show_mobilephone = $request->has('opt_show_mobilephone') ? true : false;
        $user->opt_show_homephone = $request->has('opt_show_homephone') ? true : false;
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
