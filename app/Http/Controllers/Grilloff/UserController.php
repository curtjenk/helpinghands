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
    public function vote(Request $request)
    {
        // Log::debug($request->all());
        Log::debug($request->person);
        Log::debug($request->vote);

        return response()->json($request->person);
    }
    /**
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Log::debug("login user");
        // Log::debug($request->all());
        // Log::debug(config('app.pitmaster'));

        $person = $this->getUser($request->name, $request->email);

        if (!isset($person)) {
            DB::table('grillusers')->insert([
                'name'=>$request->name, 
                'email'=>$request->email, 'type'=>2]);
            $person = $this->getUser($request->name, $request->email);
        }

        if ($person->email == config('app.pitmaster')) {
            return response()->json($person);
        }
        return response()->json($person);
    }
 
    private function getUser($name, $email) {
        return DB::table('grillusers')
            ->where('email', $email)
            ->where('name', $name)
            ->first();
    }
   
}
