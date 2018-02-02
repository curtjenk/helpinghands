<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Common\Inputs;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\EventNotification;
use App;
use Auth;
use Storage;
use Cache;
use DB;
use Log;

class EventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

// handle online signup versus email signup.
    public function signup(Request $request, $event_id)
    {
        $user = Auth::user();
        $event = App\Event::findOrFail($event_id);
        $resp = App\Response::where('event_id',$event->id)
            ->where('user_id',$user->id)->first();
        $helping = $request->input('h', 'false');

        $num_signups = App\Response::where('event_id', $event_id)
            ->where('helping', true)->get()->count();

        if($event->signup_limit > 0 && $num_signups == $event->signup_limit){
            // Log::debug('limit reached '.$user->name.' '.$event->subject);
            return redirect()->back()->withErrors([
                'msg'=>'Sorry, this event is filled! Thanks for your interest.']);
        }

        //Log::debug("helping = $helping");
        if (!$resp) { //no evite sent but user is signing-up or declining
            App\Response::create([
                'user_id'=>$user->id,
                'event_id'=>$event->id,
                'helping'=>$helping,
                'token'=>null
            ]);
        } else {
            //Toggle response
            $resp->helping = $helping;
            $resp->save();
        }
        return redirect()->back();
    }
    /*

     */
    public function calendar(Request $request)
    {
        // $this->authorize('list-events');
        $user = Auth::user();
        $organization_id = $this->getOrg($request, $user);
        $query=App\Event::select('id', 'subject', 'date_start', 'date_end')
            // ->where('organization_id', $organization_id)
            ->orderBy('events.date_start', 'asc')
            ->get();

        $counts=App\Event::select(DB::raw("to_char(date_start, 'YYYY mm Mon') as interval, count(*) as num"))
            // ->where('organization_id', $organization_id)
            ->whereRaw("to_char(date_start, 'YYYYMM') >= '".Carbon::now()->subMonths(3)->format('Ym')."'")
            ->groupBy('interval')
            ->orderBy('interval', 'asc')
            ->limit(6)
            ->get();

        return view('event.calendar', [
                'events'=>$query,
                'counts'=>$counts
            ]);
    }
    /**
     * Send an email to people who've signed-up for this event.
     * @param Request $request [description]
     */
    public function notify(Request $request, $event_id)
    {
        $event = App\Event::findOrFail($event_id);
        $this->authorize('update', $event);
        $this->validate($request, [
            'message' => 'required',
        ]);
        $signups = $event->signups()->get();
        $message = $request->input('message');
        // dump($signups);
        foreach ($signups as $u) {
            Mail::to($u)->queue(new EventNotification($event, $u, $message));
        }
        //dump($request->input('message'));
        return redirect('/event');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $inputs = new Inputs($request,
            [ ]
        );
        // $organization_id = $this->getOrg($request, $user);

        //TODO: return only the events the user can see
        //TODO: ie. where he/she is a member of the events organizations/teams
        $query = $user->memberships()
            ->select('events.*', 'organizations.id as organization_id',
                'organizations.name as organization_name',
                'teams.id as team_id', 'teams.name as team_name',
                'statuses.name as status', 'event_types.name as type',
                DB::raw('sum(CASE responses.helping WHEN true THEN 1 ELSE 0 END) AS yes_responses'),
                DB::raw('sum(CASE responses.helping WHEN false THEN 1 ELSE 0 END) AS no_responses')
            )
            ->join('events', 'events.organization_id', '=', 'organizations.id')
            ->leftjoin('responses', 'responses.event_id', '=', 'events.id')
            ->join('statuses', 'statuses.id', '=', 'events.status_id')
            ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
            ->leftjoin('teams', 'teams.id', '=', 'events.team_id')
            // ->where('organization_id', $organization_id)
            ->when($inputs->filter, function($q) use($inputs){
                return $q->where(function($q2) use($inputs) {
                    $q2->where('events.subject', 'like', '%'.$inputs->filter.'%')
                    ->orWhere('events.description', 'like', '%'.$inputs->filter.'%');
                });
            })
            ->when($inputs->orgid, function($org) use($inputs) {
                $org->where('events.organization_id',$inputs->orgid)
                    ->when($inputs->teamid, function($team) use($inputs) {
                        $team->where('events.team_id', $inputs->teamid);
                    });
            })
            ->when($inputs->sort, function($q) use($inputs){
                return $q->orderby($inputs->sort, $inputs->direction);
            })
            ->groupby('events.id')
            ->groupby('organizations.id')
            ->groupby('teams.id')
            ->groupby('statuses.id')
            ->groupby('event_types.id');


        //foreach();
        //$authorizations = ["can_update_event"=>$canUpdateEvent,
        //                   "can_show_event"=>true,
        //                   "can_create_event"=>$canCreateEvent];
        $query = $query->paginate($inputs->limit);
        foreach ($query->items() as &$item)
        {
            if (isset($item->team_id)) {
                Log::debug("team ".$item->team_id);
                $canUpdateEvent = $user->has_team_permission($item->team_id, 'Update event');
                $canShowEvent   = $user->has_team_permission($item->team_id, 'Show event');
                $canCreateEvent = $user->has_team_permission($item->team_id, 'Create event');
            } else {
                $canUpdateEvent = $user->has_org_permission($item->organization_id, 'Update event');
                $canShowEvent   = $user->has_org_permission($item->organization_id, 'Show event');
                $canCreateEvent = $user->has_org_permission($item->organization_id, 'Create event');
            }
            $item->can_update_event = $canUpdateEvent;
            $item->can_create_event = $canCreateEvent;
            $item->can_show_event = $canShowEvent;
        }

        return $query;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
    //     $this->authorize('create-event');
    //     $user = Auth::user();
    //
    //     $orgs = App\Organization::select('organizations.*')
    //         // ->when($user->is_orgLevel(), function($q) use($user) {
    //         //     return $q->where('organizations.id', $user->organization_id);
    //         // })
    //         ->get();
    //
    //     return view('event.create_edit',
    //         ['orgs'=>$orgs,
    //          'statuses'=>App\Status::all(),
    //          'event_types'=>App\EventType::all(),
    //      ]);
    // }

    public function members(Request $request, $id)
    {
        $user = Auth::user();
        $event = App\Event::findOrFail($id);
        $this->authorize('show', $event);
        $members = App\User::select('users.*', 'responses.*')
            ->join('responses', function($join) use($event){
                $join->on('responses.user_id', 'users.id')
                    ->where('responses.event_id', $event->id)
                    ->where('responses.helping', true);
                }
        )->distinct()
        ->orderby('responses.updated_at', 'asc')
        ->get();

        return response()->json($members);
    }
    /**
     * Download the requested file/attachment
     * @param  Request $request [description]
     * @param  [type]  $event_id      [description]
     * @param  [type]  $file_id [description]
     * @return [type]           [description]
     */
    public function download(Request $request, $event_id, $file_id)
    {
        $user = Auth::user();
        $event = App\Event::findOrFail($event_id);
        $this->authorize('show', $event);
        $file = App\EventFiles::where('id', $file_id)
            ->where('event_id', $event->id)
            ->first();
        if(!isset($file)){
            Log::debug("File not found. id = ".$file_id." event=".$event_id);
            return;
        }
        $pathToFile =  Storage::disk('public')
            ->getDriver()->getAdapter()
            ->applyPathPrefix($file->filename);
        //dump($pathToFile);
        return response()->download($pathToFile, $file->original_filename);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Log::debug(print_r($request->all(),true));
        $user = Auth::user();
        $this->authorize('create-event');
        // $event = json_decode($request->event);
        $this->validate($request, [
            'event.subject' => 'required|max:255',
            // 'event.description' => 'required|string',
            'event.date_start' => 'required',
            'event.date_end' => 'required',
            'organization_id' => 'required|exists:organizations,id',
            'event.event_type_id' => 'required|exists:event_types,id',
            'event.status_id' => 'required|exists:statuses,id',
            // 'event.signup_limit'=> 'string',
            // 'event.cost'=> 'string'
        ]);

        // // dump($request->all());
        $newEvent = App\Event::create([
            'subject'=>$request->input('event.subject'),
            'description'=>$request->input('event.description'),
            'description_text'=>$request->input('event.description_text'),
            'date_start'=>$request->input('event.date_start'),
            'date_end'=>$request->input('event.date_end'),
            'time_start'=>json_encode($request->input('event.time_start')),
            'time_end'=>json_encode($request->input('event.time_end')),
            'user_id'=>$user->id,
            'status_id'=>$request->input('event.status_id'),
            'event_type_id'=>$request->input('event.event_type_id'),
            'organization_id'=>$request->input('organization_id'),
            'team_id'=>$request->input('team_id'),
            'signup_limit'=>$request->input('event.signup_limit'),
            'cost'=>$request->input('event.cost'),
        ]);

        return response(['id'=>$newEvent->id]);
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
    //     $event = App\Event::findOrFail($id);
    //     $this->authorize('show', $event);
    //     return view('event.show', [
    //         'event'=>$event,
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
    //     $user = Auth::user();
    //     $event = App\Event::findOrFail($id);
    //     $this->authorize('update', $event);
    //
    //     $orgs = [];
    //     return view('event.create_edit', [
    //         'event'=>$event,
    //         'orgs'=>$orgs,
    //         'statuses'=>App\Status::all(),
    //         'event_types'=>App\EventType::all()
    //     ]);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Log::debug(print_r($request->all(),true));
        $user = Auth::user();
        $event = App\Event::findOrFail($id);
        $this->authorize('update', $event);
        // $event = json_decode($request->event);
        $this->validate($request, [
            'event.subject' => 'required|max:255',
            // 'event.description' => 'required|string',
            'event.date_start' => 'required',
            'event.date_end' => 'required',
            'organization_id' => 'required|exists:organizations,id',
            'event.event_type_id' => 'required|exists:event_types,id',
            'event.status_id' => 'required|exists:statuses,id',
            // 'event.signup_limit'=> 'string',
            // 'event.cost'=> 'string'
        ]);

        $event->subject = $request->input('event.subject');
        $event->description = $request->input('event.description');
        $event->description_text = $request->input('event.description_text');
        $event->date_start = $request->input('event.date_start');
        $event->date_end = $request->input('event.date_end');
        $event->time_start = json_encode($request->input('event.time_start'));
        $event->time_end = json_encode($request->input('event.time_end'));
        $event->updated_user_id = $user->id;
        $event->organization_id = $request->organization_id;
        $event->team_id = $request->team_id;
        $event->status_id = $request->input('event.status_id');
        $event->event_type_id = $request->input('event.event_type_id');
        $event->signup_limit = $request->input('event.signup_limit', 0);
        $event->cost = $request->input('event.cost', 0);
        $event->save();

        return response(['id'=>$event->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $event = App\Event::findOrFail($id);
        $this->authorize('destroy', $event);

        $event->delete();
        return redirect('/event');
    }

}
