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
        if (empty($request->email) || empty($request->name)){
            abort(400);
        }
        $name = strtoupper($request->name);
        $email = $request->email;

        if ($name == config('app.pitmaster')) {
            if ($email != config('app.pitmaster')) {
                abort(400);
            }
        }
        if ( !($email == config('app.thesecret') ||
               $email == config('app.pitmaster') )
        ) {
            abort(400);
        } 
       
        $person = $this->getUser($name, $email);

        if (!isset($person)) {
            DB::table('grillusers')->insert([
                'name'=>$name, 
                'type'=>2]);
            $person = $this->getUser($name, $email);
        }

        return response()->json($person);
    }
 
    private function getUser($name) {
        return DB::table('grillusers')
            ->where('name', $name)
            ->first();
    }
   
}
