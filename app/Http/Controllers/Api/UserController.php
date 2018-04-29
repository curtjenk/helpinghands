<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\Inputs;
use App\Lib\StopWatch;
use App;
use Auth;
use DB;
use Log;
use Storage;
use Hash;
// use Monolog\Handler\FingersCrossed\ActivationStrategyInterface;

class UserController extends Controller
{
    public function yes_responses($id)
    {
        $user = Auth::user();
        $member = App\User::findOrFail($id);
        $this->authorize('show', $member);
        $responses = $member->responses()
        ->select("events.id", "events.subject", 'events.date_start', 'events.date_end')
        ->join('events', 'events.id', '=', 'responses.event_id')
        ->where('responses.helping', true)
        ->orderby('events.date_end','asc')
        ->get();

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

    public function membership(Request $request, $id)
    {
        $user = App\User::findOrFail($id);
        $this->authorize("show", $user);
        $memberships = $user->memberships()
                        ->where('organizations.name','!=','Ministry Engage');

        if ($user->superUser()) {
            return response()->json($memberships->get(['*', DB::raw(" 'Admin' AS role")]));
        } else {
            return response()->json($memberships->get());
        }
    }
    /**
     * Get list of events the $userid has access to
     * @param  Request $request [description]
     * @param  [type]  $userid  [description]
     * @return [type]           [description]
     */
    public function proxy_events(Request $request, $user_id)
    {
        $authUser = Auth::user();
        $this->authorize('list-users');

        $user = App\User::findOrFail($user_id);
        $this->authorize("show", $user);
        // TODO
        $query = $user->memberships()
            ->select('events.*', 'organizations.id as organization_id',
                'organizations.name as organization_name',
                'teams.id as team_id', 'teams.name as team_name',
                'statuses.name as status'
            )
            ->join('events', 'events.organization_id', '=', 'organizations.id')
            ->join('statuses', 'statuses.id', '=', 'events.status_id')
            ->leftjoin('teams', 'teams.id', '=', 'events.team_id')
            ->where('statuses.name','Open');

        return response()->json($query->get());
    }
    /**
     * Get list of members who could possibly signup for the $event_id
     * @param  Request $request [description]
     * @param  [type]  $event_id  [description]
     * @return [type]           [description]
     */
    public function proxy_members(Request $request, $event_id)
    {
        $user = Auth::user();
        $this->authorize('list-users');
        $this->authorize('list-events');

        $event = App\Event::findOrFail($event_id);
        $this->authorize("show", $event);

        $query = $user->peers($event->organization_id, $event->team_id)
            ->where('users.active',true);

        return response()->json($query->get());
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

        $inputs = new Inputs($request,
            [ ]
        );

        if ($user->superuser()) {
            // Log::debug('f1');
            $query = App\User::with(['organizations','organizations.teams'])
                ->when($inputs->orgid, function($q) use($inputs) {
                    $q->join('organization_user','organization_user.user_id','=','users.id')
                    ->where('organization_user.organization_id', $inputs->orgid);
                })
                ->when($inputs->teamid, function($q) use($inputs) {

                    $q->join('team_user','team_user.user_id','=','users.id')
                    ->where('team_user.team_id', $inputs->teamid);
                })
                ->where('users.name', '!=', 'Site')
                ->distinct();
        } else {
            $query = $user->peers($inputs->orgid, $inputs->teamid);
        }

        $query = $query->select('users.*', DB::raw('COALESCE(r.yes_responses,0) as yes_responses' ))
            ->leftjoin(DB::raw('LATERAL (Select user_id,
                    sum(CASE helping WHEN true THEN 1 ELSE 0 END) AS yes_responses
                    from responses group by user_id) as r'), function($q) {
                $q->on('users.id', '=', 'r.user_id');
            })
            ->when($inputs->filter, function($q) use($inputs){
                return $q->where(function($q2) use($inputs) {
                    $q2->where('users.name', 'like', '%'.$inputs->filter.'%')
                    ->orWhere('users.email', 'like', '%'.$inputs->filter.'%');
                });
            })
            ->when($inputs->sort, function($q) use($inputs){
                return $q->orderby($inputs->sort, $inputs->direction);
            });

        $query = $query->paginate($inputs->limit);
        $canUpdateUser = false;
        $canUpdateEvent = false;
        foreach($query as &$row) {
            foreach($row->organizations as $org) {
                if (!$canUpdateUser) {
                 $canUpdateUser = $user->has_permission('Update user', $org->id);
                }
                if (!$canUpdateEvent) {
                 $canUpdateEvent = $user->has_permission('Update event', $org->id);
                }
            }
            $row->canUpdateUser = $canUpdateUser;
            $row->canUpdateEvent = $canUpdateEvent;
            $canUpdateUser = false;
            $canUpdateEvent = false;
        }
        return $query;
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

        return view('user.create_edit',
            ['orgs'=>$orgs,
             'roles'=>$roles]);
    }

    /**
     * The authenticated user is signing-up on behalf of $user_id
     * @param  Request $request [description]
     * @param  $id [ID of the user to signup for events || ID of the event for users]
     * @return [type]           [description]
     */
    public function proxy_signup(Request $request, $id)
    {
        $user = Auth::user();
        $eventSignup = $request->input('event');
        if ($eventSignup) {
            return $this->proxy_signup_event($request, $id);
        } else {
            return $this->proxy_signup_user($request, $id);
        }

    }
    /**
     * Signup the $user_id for 1 or more events
     * @param  [type] $user_id [description]
     * @return [type]          [description]
     */
    private function proxy_signup_user (Request $request, $user_id)
    {
        $proxy_user = App\User::findOrFail($user_id);
        $event_ids = $request->input('event_ids');
        $action = $request->input('action');

        foreach ($event_ids as $event_id) {
            $event = App\Event::findOrFail($event_id);
            $this->authorize('view', $event);
        }
        // //Log::debug($event->subject);
        foreach ($event_ids as $event_id) {
            $event = App\Event::findOrFail($event_id);
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
        }

        return;
    }
    /**
     * Signup users for the $event_id
     * @param  [type] $event_id [description]
     * @return [type]           [description]
     */
    private function proxy_signup_event (Request $request, $event_id)
    {
        $proxy_event = App\User::findOrFail($event_id);
        $user_ids = $request->input('member_ids');
        $action = $request->input('action');

        $eligible_userids = [];
        foreach ($user_ids as $user_id) {
            $user = App\User::findOrFail($user_id);
            $can = $user->has_permission('Show event', $proxy_event->organization_id, $proxy_event->team_id);
            if ($can) {
                $resp = App\Response::where('event_id',$proxy_event->id)
                    ->where('user_id',$user_id)->first();

                $helping = $action=='signup'? 1 : 0;

                if ($resp) {
                    $resp->helping = $helping;
                    $resp->save();
                } else {
                    App\Response::create([
                        'user_id'=>$user_id,
                        'event_id'=>$proxy_event->id,
                        'helping'=>$helping,
                        'token'=>null
                    ]);
                }

            }
        }

    }
    /**
     * Save user's avatar
     * @param  Request $request [description]
     * @param  [type]  $id      [description]
     * @return [type]           [description]
     */
    public function avatar(Request $request, $id)
    {
        $user = App\User::findOrFail($id);
        $self = Auth::user();
        // $this->authorize('update', $user);

        $dir = 'avatars/'.$user->id;
        $upload = $request->file('photo');

        if (isset($upload)) {
            //Delete previous photo/avatar
            try {
                Storage::disk('public')->deleteDirectory($dir);
            } catch (Exception $e) {}

            $original = $upload->getClientOriginalName();
            $filename = $upload->store($dir, 'public');
            // Log::debug(Storage::disk('public')->url($filename));
            $user->avatar_filename = 'storage/'.$filename;
            $user->save();
        }
        return response()->json($user->filename);
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
    /*

     */
    public function authmember()
    {
        // StopWatch::start('authmember');
        $user = Auth::user();
        if (!is_null($user)) {
            $roles = $user->roles()->get()->pluck('name');
            $permissions = $user->permissions()->get()->pluck('name');
        } else {
            $roles = [];
            $permissions = [];
        }
        // StopWatch::stop('authmember');
        // StopWatch::show(true);

        return response()->json(['user'=>$user,
                                'roles'=>$roles,
                                'permissions'=>$permissions]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //     //dump("here");
    //     $user = App\User::where('id',$id)->with(['organizations','teams'])->first();
    //     if (!isset($user)) {
    //         abort(400);
    //     }
    //     $this->authorize('show', $user);
    //     return view('user.profile', [
    //         'user'=>$user,
    //     ]);
    // }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function edit($id)
    // {
    //     $self = Auth::user();
    //     $user = App\User::where('id',$id)->with(['organizations','teams'])->first();
    //     $this->authorize('update', $user);
    //     // Log::debug(print_r($user,true));
    //     return view('user.profile', [
    //         'user'=>$user,
    //         'orgteams'=> App\Organization::with('teams')
    //             ->where('organizations.name','!=','Ministry Engage')
    //             ->get()
    //     ]);
    // }

    public function update_email(Request $request, $id)
    {
        $user = App\User::findOrFail($id);
        $self = Auth::user();
        // $this->authorize('update', $user);
        if ($user->id != $self->id) {
            App::abort(401, 'Not you. Cant update');
        }
        $check = App\User::where('email', $request->input('newEmail'))->first();
        if (isset($check)) {
            return response('unavailable',400);
        }

        $user->email = $request->input('newEmail');
        $user->save();
        return;
    }

    public function update_password(Request $request, $id)
    {
        $user = App\User::findOrFail($id);
        $self = Auth::user();
        // $this->authorize('update', $user);
        if ($user->id != $self->id) {
            App::abort(401, 'Not you. Cant update');
        }
        if(Hash::check($request->input('oldPassword'), $user->password))
        {
            $new = $request->input('newPassword');
            $newConf = $request->input('newPasswordConfirm');
            if ($new == $newConf) {
                $user->password = Hash::make($new);
                $user->save;
                return response('ok',200);
            }
        }

        return response('verify',400);

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
        // Log::debug($request->all());
        $user = App\User::findOrFail($id);

        $this->authorize('update', $user);
        $updUser = $request->input('user');
        $updOrg  = $request->input('org');

        $user->email = $updUser['email'];
        $user->name = $updUser['name'];
        $user->nickname = $updUser['nickname'];
        $user->mobilephone = $updUser['mobilephone'];
        $user->homephone = $updUser['homephone'];

        // $user->opt_receive_evite = $updUser['opt_receive_evite'];
        $user->opt_show_email = $updUser['opt_show_email'];
        $user->opt_show_mobilephone = $updUser['opt_show_mobilephone'];
        $user->opt_show_homephone = $updUser['opt_show_homephone'];

        $user->organizations()->detach();
        $user->teams()->detach();

        foreach($updOrg as $org){
            if ($org['checked']) {
                $user->organizations()->attach($org['id'],
                    ['role_id'=>App\Role::where('name','Member')->pluck('id')->first()]);
            }
            foreach($org['teams'] as $team) {
                if($team['checked']) {
                    $user->teams()->attach($team['id'],
                    ['role_id'=>App\Role::where('name','Member')->pluck('id')->first()]);
                }
            }
        }

        $user->save();
        //
        return response()->json($user->id);
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
