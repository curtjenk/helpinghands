<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Common\Inputs;
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
    public function index(Request $request)
    {
        $user = Auth::user();
        $inputs = new Inputs($request,
            [ ]
        );

        foreach (App\EventType::all() as $et) {
            $eventTypes[$et->name] = 0;
        }
        $data['EventTypesOverTime'] =
            $this->events_over_time($eventTypes, $inputs->orgid, $inputs->teamid);
        $data['TotalByType'] =
            $this->total_by_type($eventTypes, $inputs->orgid, $inputs->teamid);
        $data['ParticpationRate'] =
            $this->overall_particiption($inputs->orgid, $inputs->teamid);
        $data['ParticpationOverTime'] =
            $this->particiption_over_time($inputs->orgid, $inputs->teamid);
        return response()->json($data);
    }
    /**
     * [particiption_over_time description]
     * @return [type] [description]
     */
    private function particiption_over_time($org_id, $team_id)
    {
        $query = App\Response::selectRaw(
            "to_char(date_start, 'YYYY mm')  as interval,
             sum(case helping when true then 1 else 0 end)*100/count(*) as Yes,
             sum(case helping when false then 1 else 0 end)*100/count(*) as No,
             sum(case when helping is null  then 1 else 0 end)*100/count(*) as NoReply"
            )
            ->join('events', 'events.id', '=', 'responses.event_id')
            ->when(isset($org_id), function($q) use($org_id) {
                $q->where('events.organization_id', $org_id);
            })
            ->when(isset($team_id), function($q) use($team_id) {
                $q->where('events.team_id', $team_id);
            })
            ->groupby("interval")
            ->get();

        return $query;
    }
    /**
     * [overall_particiption description]
     * @return [type] [description]
     */
    private function overall_particiption($org_id, $team_id)
    {
        $query = App\Response::selectRaw(
            "sum(case helping when true then 1 else 0 end)*100/count(*) as yes,
             sum(case helping when false then 1 else 0 end)*100/count(*) as no,
             sum(case when helping is null  then 1 else 0 end)*100/count(*) as noreply"
            )
            ->join('events', 'events.id', '=', 'responses.event_id')
            ->when(isset($org_id), function($q) use($org_id) {
                $q->where('events.organization_id', $org_id);
            })
            ->when(isset($team_id), function($q) use($team_id) {
                $q->where('events.team_id', $team_id);
            })
            // ->whereNotIn('event_id', [1,2,4])
            ->first();

        return $query;
    }
    /**
     *  Get Year-To-Date total for each event type
     * @return [type] [description]
     */
    private function total_by_type($eventTypes, $org_id, $team_id)
    {
        $totalByType = [];
        $query = App\Event::select(DB::raw("event_types.name, count(*) as num"))
            ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
            ->where('date_start', '>=', date('Y-01-01'))
            ->when(isset($org_id), function($q) use($org_id) {
                $q->where('events.organization_id', $org_id);
            })
            ->when(isset($team_id), function($q) use($team_id) {
                $q->where('events.team_id', $team_id);
            })
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
    private function events_over_time($eventTypes, $org_id, $team_id)
    {
        $eventsOverTime = [];
        $query = App\Event::select(DB::raw("to_char(date_start, 'YYYY mm')  as interval,
            event_types.name, count(*) as num"))
            ->join('event_types', 'event_types.id', '=', 'events.event_type_id')
            ->when(isset($org_id), function($q) use($org_id) {
                $q->where('events.organization_id', $org_id);
            })
            ->when(isset($team_id), function($q) use($team_id) {
                $q->where('events.team_id', $team_id);
            })
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
