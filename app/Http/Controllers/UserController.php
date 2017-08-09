<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\Inputs;
use App;
use Auth;
use DB;
use Log;

class UserController extends Controller
{
    public function yes_responses($id)
    {
        $user = Auth::user();
        $member = App\User::findOrFail($id);
        $this->authorize('show', $member);
        $responses = $member->responses()
        ->select("events.subject", 'events.date_start', 'events.date_end')
        ->join('events', 'events.id', '=', 'responses.event_id')
        ->where('responses.helping', true)
        ->orderby('events.date_end','asc')
        ->get();

        // $responses = App\User::
        //     leftjoin('responses', 'responses.user_id', '=', 'users.id')
        //     ->leftjoin('events', 'events.id', '=', 'responses.event_id')
        //     ->groupby('users.id')
        //     ->groupby('responses.id')
        //     ->groupby('events.id')
        //     ->paginate(10);

        return response()->json($responses);
    }
    /**
     * Get list of members who signed-up for the event
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function signups(Request $request, $event_id)
    {
        $user = Auth::user();
        $this->authorize('list-users');
        $event = App\Event::findOrFail($event_id);
        $this->authorize('show', $event);
        if (!$request->ajax()) {
            return abort(400);
        }
        return response()->json($event->signups()->get());
    }
    /**
     *
     */
    public function pay(Request $request, $event_id)
    {
        $user = Auth::user();
        $this->authorize('list-users');
        $this->authorize('administer');
        $event = App\Event::findOrFail($event_id);
        $this->authorize('show', $event);

        //Log::debug($request->input('pay'));
        $paid_ids = $request->input('pay');
        if (!empty($paid_ids))
        {
            foreach($paid_ids as $user_id) {
                $resp = App\Response::where('event_id',$event_id)
                    ->where('user_id', $user_id)
                    ->first();
                $resp->paid = true;
                $resp->save();
            }
        }
        //Now handle "unchecks"
        foreach ($event->signups()->get()->pluck('id')->diff($paid_ids) as $not)
        {
            $resp = App\Response::where('event_id',$event_id)
                ->where('user_id', $not)
                ->first();
            $resp->paid = false;
            $resp->save();
        }

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('list-users');
        $user = Auth::user();
        if (!$request->ajax()) {
            return view('user.memberslist', []);
        }

        $inputs = new Inputs($request,
            [ ]
        );
        //Log::debug($inputs->all());
        $organization_id = $this->getOrg($request, $user);
        // Log::debug('orgid='.$organization_id);
        return App\User::       //with('organization')
            select('users.*', DB::raw('sum(CASE responses.helping WHEN true THEN 1 ELSE 0 END) AS yes_responses'))
            ->leftjoin('responses', 'responses.user_id', '=', 'users.id')
            ->where('role_id', '!=', 1)
            ->where('organization_id', $organization_id)
            // ->when($user->is_orgLevel(), function($q) use($user) {
            //     return $q->where('organization_id', $user->organization_id);
            // })
            ->when($inputs->filter, function($q) use($inputs){
                return $q->where(function($q2) use($inputs) {
                    $q2->where('users.name', 'like', '%'.$inputs->filter.'%')
                    ->orWhere('users.email', 'like', '%'.$inputs->filter.'%');
                });
            })
            ->when($inputs->sort, function($q) use($inputs){
                return $q->orderby($inputs->sort, $inputs->direction);
            })
            ->groupby('users.id')
            ->paginate(10);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function deleteMeOLDindex()
    // {
    //     $this->authorize('list-users');
    //     $user = Auth::user();
    //
    //     $query=App\User::with('organization')
    //         ->where('role_id', '!=', 1)
    //         ->where('role_id', '>=', $user->role_id)
    //         //->where('users.id', '!=', $user->id)
    //         ->when($user->is_orgLevel(), function($q) use($user) {
    //             return $q->where('organization_id', $user->organization_id);
    //         })
    //         ->get();
    //
    //     return view('user.index', [
    //             'users'=>$query,
    //         ]);
    // }
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

        return view('user.create_edit',
            ['orgs'=>$orgs,
             'roles'=>$roles]);
    }

    /**
     * The authenticated user is signing-up on behalf of $user_id
     * @param  Request $request [description]
     * @param  [type]  $user_id [description]
     * @return [type]           [description]
     */
    public function proxy_signup(Request $request, $user_id)
    {
        $user = Auth::user();
        $proxy_user = App\User::findOrFail($user_id);

        $event_id = $request->input('event_id');
        $action = $request->input('action');

        $event = App\Event::findOrFail($event_id);
        $this->authorize('view', $event);
        //Log::debug($event->subject);
        $resp = App\Response::where('event_id',$event->id)
            ->where('user_id',$proxy_user->id)->first();

        $helping = $action=='signup'? 1 : 0;

        if ($resp) {
            $resp->helping = $helping;
            $resp->save();
        } else {
            App\Response::create([
                'user_id'=>$proxy_user->id,
                'event_id'=>$event->id,
                'helping'=>$helping,
                'token'=>null
            ]);
        }

        return redirect()->back();
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
            'nickname' => 'max:255',
            'mobilephone' => 'max:255',
            'homephone' => 'max:255',
            'organization_id' => 'required|exists:organizations,id',
            'role_id' => 'required|exists:roles,id',
        ]);
        $newuser = App\User::create([
            'name'=>$request->input('name'),
            'email'=>$request->input('email'),
            'nickname'=>$request->input('nickname'),
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
        //$this->authorize('update', $user);
        $roles = App\Role::where('roles.id', '>=', $self->role_id)
            ->where('roles.name', '!=', 'Super User')
            ->get();
        $orgs = App\Organization::select('organizations.*')
            ->when($self->is_orgLevel(), function($q) use($self) {
                return $q->where('organizations.id', $self->organization_id);
            })
            ->get();

        return view('user.create_edit', [
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
            'email' => 'required|max:255',
            'nickname' => 'max:255',
            'mobilephone' => 'max:255',
            'homephone' => 'max:255',
            'org_id' => 'required|exists:organizations,id',
            'role_id' => 'required|exists:roles,id',
            //'new_password' => 'confirmed|required_with:old_password',
        ]);
        $user = App\User::findOrFail($id);
        $self = Auth::user();
        $this->authorize('update', $user);
        $user->email = $request->input('email');
        $user->name = $request->input('name');
        $user->nickname = $request->input('nickname');
        $user->mobilephone = $request->input('mobilephone');
        $user->homephone = $request->input('homephone');
        $user->organization_id = $request->input('org_id');
        $user->role_id = $request->input('role_id');

        $user->opt_receive_evite = $request->has('opt_receive_evite') ? true : false;
        $user->opt_show_email = $request->has('opt_show_email') ? true : false;
        $user->opt_show_mobilephone = $request->has('opt_show_mobilephone') ? true : false;
        $user->opt_show_homephone = $request->has('opt_show_homephone') ? true : false;
        $user->save();
        return view('user.show', [
            'user'=>$user,
        ]);
        //return redirect('/member/'.$id);
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
        return redirect('/member');
    }
}
