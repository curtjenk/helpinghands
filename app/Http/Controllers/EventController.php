<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\Inputs;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\EventNotification;
use App;
use Auth;
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
    public function calendar()
    {
        $this->authorize('list-events');
        $user = Auth::user();
        $query=App\Event::select('id', 'subject', 'date_start', 'date_end')
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organization_id', $user->organization_id);
            })
            ->orderBy('events.date_start', 'asc')
            ->get();

        $counts=App\Event::select(DB::raw("to_char(date_start, 'YYYY mm Mon') as interval, count(*) as num"))
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organization_id', $user->organization_id);
            })
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
            // dump($u);
            // if ($u->id != 3){
            // Log::debug($u->email);
            Mail::to($u)->queue(new EventNotification($event, $u, $message));
            // }
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
        $this->authorize('list-events');
        $user = Auth::user();
        if (!$request->ajax()) {
            return view('event.index', []);
        }

        $inputs = new Inputs($request,
            [ ]
        );
        $query = App\Event::
            select('events.*', 'statuses.name as status', 'event_types.name as type',
                DB::raw('sum(CASE responses.helping WHEN true THEN 1 ELSE 0 END) AS yes_responses'),
                DB::raw('sum(CASE responses.helping WHEN false THEN 1 ELSE 0 END) AS no_responses')
            )
            ->leftjoin('responses', 'responses.event_id', '=', 'events.id')
            ->join('statuses', 'statuses.id', '=', 'events.status_id')
            ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organization_id', $user->organization_id);
            })
            ->when($inputs->filter, function($q) use($inputs){
                return $q->where(function($q2) use($inputs) {
                    $q2->where('events.subject', 'like', '%'.$inputs->filter.'%')
                    ->orWhere('events.description', 'like', '%'.$inputs->filter.'%');
                });
            })
            ->when($inputs->sort, function($q) use($inputs){
                return $q->orderby($inputs->sort, $inputs->direction);
            })
            ->groupby('events.id')
            ->groupby('statuses.id')
            ->groupby('event_types.id');

        //check that it wasn't a vue-tables-2 request
        if ($request->input('paginate') == '0') {
            // $open_status = App\Status::where('name', 'Open')->first()->pluck('id');
            $query = $query->where('statuses.name', 'Open')
                ->orderby('events.date_start', 'desc');
            return response()->json($query->get());
        } else {
            return $query->paginate(10);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create-event');
        $user = Auth::user();

        $orgs = App\Organization::select('organizations.*')
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organizations.id', $user->organization_id);
            })
            ->get();

        return view('event.create',
            ['orgs'=>$orgs,
             'statuses'=>App\Status::all(),
             'event_types'=>App\EventType::all(),
         ]);
    }

    public function members(Request $request, $id)
    {
        $user = Auth::user();
        $event = App\Event::findOrFail($id);
        $this->authorize('show', $event);
        $members = App\User::join('responses', function($join) use($event){
            $join->on('responses.user_id', 'users.id')
                ->where('responses.event_id', $event->id)
                ->where('responses.helping', true);
        })
        ->distinct()
        ->get();

        return response()->json($members);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $this->authorize('create-event');
        $this->validate($request, [
            'subject' => 'required|max:255',
            'description' => 'string',
            'date_start' => 'date',
            'date_end' => 'date',
            'organization_id' => 'required|exists:organizations,id',
            'event_type_id' => 'required|exists:event_types,id',
            'status_id' => 'required|exists:statuses,id',
            'signup_limit'=> 'required|numeric',
            'cost'=> 'required|regex:/^\d*(\.\d{1,2})?$/'
        ]);
        // dump($request->all());
        $newEvent = App\Event::create([
            'subject'=>$request->input('subject'),
            'description'=>$request->input('description'),
            'date_start'=>$request->input('date_start'),
            'date_end'=>$request->input('date_end'),
            'user_id'=>$user->id,
            'status_id'=>$request->input('status_id'),
            'event_type_id'=>$request->input('event_type_id'),
            'organization_id'=>$request->input('organization_id'),
            'signup_limit'=>$request->input('signup_limit'),
            'cost'=>$request->input('cost'),
        ]);
        return view('event.show', [
            'event'=>$newEvent,
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
        $user = Auth::user();
        $event = App\Event::findOrFail($id);
        $this->authorize('show', $event);
        return view('event.show', [
            'event'=>$event,
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
        $user = Auth::user();
        $event = App\Event::findOrFail($id);
        $this->authorize('update', $event);
        $orgs = App\Organization::select('organizations.*')
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organizations.id', $user->organization_id);
            })
            ->get();
        return view('event.create', [
            'event'=>$event,
            'orgs'=>$orgs,
            'statuses'=>App\Status::all(),
            'event_types'=>App\EventType::all()
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
        $user = Auth::user();
        $event = App\Event::findOrFail($id);
        $this->authorize('update', $event);
        $this->validate($request, [
            'subject' => 'required|max:255',
            'description' => 'string',
            'date_start' => 'date',
            'date_end' => 'date',
            'organization_id' => 'required|exists:organizations,id',
            'event_type_id'=> 'required|exists:event_types,id',
            'status_id' => 'required|exists:statuses,id',
            'signup_limit'=> 'required|numeric',
            'cost'=> 'required|regex:/^\d*(\.\d{1,2})?$/'
        ]);

        $event->subject = $request->input('subject');
        $event->description = $request->input('description');
        $event->date_start = $request->input('date_start');
        $event->date_end = $request->input('date_end');
        $event->updated_user_id = $user->id;
        $event->organization_id = $request->input('organization_id');
        $event->status_id = $request->input('status_id');
        $event->event_type_id = $request->input('event_type_id');
        $event->signup_limit = $request->input('signup_limit');
        $event->cost = $request->input('cost');
        $event->save();
        return view('event.show', [
            'event'=>$event,
        ]);
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
