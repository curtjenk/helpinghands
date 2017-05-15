<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\Inputs;
use Carbon\Carbon;
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

    public function signup($event_id)
    {
        $user = Auth::user();
        $event = App\Event::findOrFail($event_id);
        $resp = App\Response::where('event_id',$event->id)
            ->where('user_id',$user->id)->first();
        if (!$resp) { //no evite sent but user is signing-up

            App\Response::create([
                'user_id'=>$user->id,
                'event_id'=>$event->id,
                'helping'=>true,
                'token'=>null
            ]);
        } elseif ($resp->helping == true) {
            //already signed-up (responded yes)
            return;
        } else {
            //no response to evite or responded No;  Set to Yes
            $resp->helping = true;
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

        $counts=App\Event::select(DB::raw("to_char(date_start, 'YYYY Mon') as interval, count(*) as num"))
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organization_id', $user->organization_id);
            })
            ->whereRaw("to_char(date_start, 'YYYYMM') >= '".Carbon::now()->format('Ym')."'")
            ->groupBy('interval')
            ->orderBy('interval', 'asc')
            ->limit(3)
            ->get();

        return view('event.calendar', [
                'events'=>$query,
                'counts'=>$counts
            ]);
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
        return App\Event::
            select('events.*',
                DB::raw('sum(CASE responses.helping WHEN true THEN 1 ELSE 0 END) AS yes_responses'),
                DB::raw('sum(CASE responses.helping WHEN false THEN 1 ELSE 0 END) AS no_responses')
            )
            ->leftjoin('responses', 'responses.event_id', '=', 'events.id')
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
            ->paginate(10);
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
             'statuses'=>App\Status::all()]);
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
            'status_id' => 'required|exists:statuses,id'
        ]);
        $newEvent = App\Event::create([
            'subject'=>$request->input('subject'),
            'description'=>$request->input('description'),
            'date_start'=>$request->input('date_start'),
            'date_end'=>$request->input('date_end'),
            'user_id'=>$user->id,
            'status_id'=>$request->input('status_id'),
            'organization_id'=>$request->input('organization_id')
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
            'statuses'=>App\Status::all()
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
            'status_id' => 'required|exists:statuses,id'
        ]);

        $event->subject = $request->input('subject');
        $event->description = $request->input('description');
        $event->date_start = $request->input('date_start');
        $event->date_end = $request->input('date_end');
        $event->updated_user_id = $user->id;
        $event->organization_id = $request->input('organization_id');
        $event->status_id = $request->input('status_id');
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
