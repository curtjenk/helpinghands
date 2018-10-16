<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;

class SessionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Get the number of seconds left in the session
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function get(Request $request)
    {
      if ($request->session()->has('lastActivity')) {
        $timeout = intval(config('session.lifetime')) * 60;
        return $request->session()->get('lastActivity') + $timeout - time();
      }
    }

    /**
     * Dummy method to reset the timeout
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function put(Request $request)
    {
    }

}
