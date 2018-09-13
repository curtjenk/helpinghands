<?php

namespace App\Http\Controllers\Grilloff;

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

class JudgeController extends Controller
{
     /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function vote(Request $request)
    {
        // Log::debug($request->all());
        $judge = $request->person;
        $votes = $request->vote;

        $alreadyVoted = DB::table('grillvotes')
                ->where('judge_id', $judge['id'])
                ->first();

        if (!empty($alreadyVoted)) {
            Log::debug("already voted");
            abort(409);
        }

        foreach($votes as $vote) {
            DB::table('grillvotes')->insert([
                'judge_id'=>$judge['id'], 
                'contestant_id'=>$vote['id'],
                'taste'=>$vote['taste'],
                'texture'=>$vote['text'],
                'appearance'=>$vote['appear']
                ]);
        }

        return response()->json($request->person);
    }

    public function results_delete(Request $request) 
    {   
        if (empty($request->name)) {
            abort(400);
        }
        if ($request->name != config('app.pitmaster')) {
            abort(400);
        }
    
        $res = DB::table('grillvotes')->delete();
        return response()->json($res);
    }
    public function results(Request $request)
    {
        $query = DB::table('grillvotes')
            ->join("grillusers", "grillusers.id", "=", "grillvotes.contestant_id" )
            ->select(
                DB::raw("grillusers.id as id,
                        name, sum(taste) as taste, 
                        sum(texture) as texture, 
                        sum(appearance) as appearance,
                        sum(taste)+sum(texture)+sum(appearance) as total
                        "))
            ->groupBy("grillusers.id")
            ->groupBy("name")
            ->orderByRaw("total DESC")
            ->get();
        return response()->json($query);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::debug("get all judges");
        $person = [];
        foreach (DB::table("grillusers")->where('type',2)->get() as $u) {
            $person[] = [
                'id'=>$u->id,
                'name'=>$u->name,
                'email'=>$u->email,
            ];
        }
       return response()->json($person);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::debug("store contestant");
        Log::debug($request->all());
        $name = $request->name;
        $email = $request->email;
        $type = 2;
        DB::table('grillusers')->insert(['name'=>$name, 'email'=>$email, 'type'=>$type]);
        $person = DB::table('grillusers')
                ->where('name', $name)
                ->where('email',$email)
                ->where('type',$type)
                ->first();

        return response()->json($person);
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
        Log::debug("update judge");
        Log::debug($request->all());
        $name = $request->name;
        $email = $request->email;
        $type = 2;
        $person = DB::table('grillusers')
                ->where('id', $id)
                ->update(['name'=>$name, 'email'=>$email])
               ;

       return response()->json($person);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::debug("delete contestant");
        DB::table('grillusers')
            ->where('id', $id)
            ->delete()
            ;
        return response()->json($id);
    }
}
