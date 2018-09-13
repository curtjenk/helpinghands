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

class UserController extends Controller
{
    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->email)){
            abort(400);
        }
        if ($request->name == config('app.pitmaster')) {
            if ($request->email != config('app.pitmaster')) {
                abort(400);
            }
        }
        if ( !($request->email == config('app.thesecret') ||
            $request->email == config('app.pitmaster') )
        ) {
            abort(400);
        } 

        $person = $this->getUser($request->name, $request->email);

        if (!isset($person)) {
            DB::table('grillusers')->insert([
                'name'=>$request->name, 
                'type'=>2]);
            $person = $this->getUser($request->name, $request->email);
        }

        return response()->json($person);
    }
 
    private function getUser($name) {
        return DB::table('grillusers')
            ->where('name', $name)
            ->first();
    }
   
}
