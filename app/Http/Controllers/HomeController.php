<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App;

class HomeController extends Controller
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
        $tickets = [];
        if ($user->can('list-tickets'))
        {
            $tickets = App\Ticket::all();
        }
        return view('home', ['tickets'=>$tickets]);
    }

    public function administrator() {
        $user = Auth::user();
        if (!$user->is_admin() &&
            !$user->is_superuser() &&
            !$user->is_orgAdmin()) {
            abort(403);
        }
        return view('administrator', ['user'=>$user]);
    }
}
