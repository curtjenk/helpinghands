<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App;
use Auth;
use DB;
use Log;

class eventController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
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
    public function index()
    {
        $this->authorize('list-events');
        $user = Auth::user();

        $query=App\Event::with('organization')
            ->when($user->is_orgLevel(), function($q) use($user) {
                return $q->where('organization_id', $user->organization_id);
            })
            ->orderBy('events.date_start', 'desc')
            ->get();

        return view('event.index', [
                'events'=>$query,
            ]);
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
            ['orgs'=>$orgs,]);
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
        ]);
        $newevent = App\Event::create([
            'subject'=>$request->input('subject'),
            'description'=>$request->input('description'),
            'date_start'=>$request->input('date_start'),
            'date_end'=>$request->input('date_end'),
            'user_id'=>$user->id,
            'organization_id'=>$request->input('organization_id')
        ]);
        return view('event.show', [
            'event'=>$newevent,
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
        ]);

        $event->subject = $request->input('subject');
        $event->description = $request->input('description');
        $event->date_start = $request->input('date_start');
        $event->date_end = $request->input('date_end');
        $event->updated_user_id = $user->id;
        $event->organization_id = $request->input('organization_id');
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
