<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
use DB;
use Log;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        foreach (App\EventType::all() as $et) {
            $eventTypes[$et->name] = 0;
        }
        $data['EventTypesOverTime'] = $this->events_over_time($eventTypes);
        $data['TotalByType'] = $this->total_by_type($eventTypes);
        return response()->json($data);
    }
    /**
     *  Get Year-To-Date total for each event type
     * @return [type] [description]
     */
    private function total_by_type($eventTypes)
    {
        $totalByType = [];
        $query = App\Event::select(DB::raw("event_types.name, count(*) as num"))
            ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
            ->where('date_start', '>=', date('Y-01-01'))
            ->groupby("name")
            ->get();
        foreach($eventTypes as $k=>$t) {
            $totalByType[$k] = 0;
            foreach ($query as $row) {
                if ($k == $row->name) {
                    $totalByType[$k]= $row->num;
                }
            }
        }

        return $totalByType;
    }
    /**
     * [events_over_time description]
     * @param  [type] $eventTypes [description]
     * @return [type]             [description]
     */
    private function events_over_time($eventTypes)
    {
        $eventsOverTime = [];
        $query = App\Event::select(DB::raw("to_char(date_start, 'YYYY mm')  as interval,
            event_types.name, count(*) as num"))
            ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
            ->groupby("interval")
            ->groupby("name")
            ->orderby("interval")
            ->get();
        $intervals = $query->pluck('interval')->unique();
        foreach ($intervals as $interval) {
            $eventsOverTime[] = ['interval'=>$interval, 'types'=>$eventTypes];
        }
        foreach($eventsOverTime as $key=>&$eot) {
            foreach ($query as $row) {
                // dump($eot['interval'] .":". $row->interval);
                if ($eot['interval'] == $row->interval) {
                    foreach($eot['types'] as $key=> &$type) {
                        if ($key == $row->name) {
                            $type= $row->num;
                        }
                    }
                }
            }
        }

        return $eventsOverTime;
    }

}
