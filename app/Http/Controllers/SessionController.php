<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;
use DB;
use Log;

class SessionController extends Controller
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
     * Return all session content.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        return response()->json($request->session()->all());
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $vars = [];
        foreach($request->all() as $key=>$value)
        {
            $vars[] = [$key=>$value];
            $request->session()->put($key,$value);
        }
        // Log::debug(print_r($vars,true));
        return response()->json($vars);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
    }

}
