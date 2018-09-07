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

class ContestantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::debug("get all contestants");
        $person = [];
        $query = DB::table("grillusers")->where('type',1)
            ->orderBy('id','asc')
            ->get();
        foreach ($query as $u) {
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
        $type = 1;
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
        Log::debug("update contestant");
        Log::debug($request->all());
        $name = $request->name;
        $email = $request->email;
        $type = 1;
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
