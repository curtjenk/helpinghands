<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Session;

class SessionTimeout
{
    protected $timeout;

    public function __construct() {
      // Convert min to sec
      $this->timeout = intval(config('session.lifetime')) * 60;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If the user is not logged in, there's no need to check for timeout
        if (Auth::check()) {
            $session = $request->session();
            if ($request->path() != 'logout') {
                if ($session->has('lastActivity') &&
                    time() - $session->get('lastActivity') > $this->timeout) {
                    $session->forget('lastActivity');
                    Auth::logout();
                    if ($request->ajax()) {
                        abort(401, 'Your session expired.');
                    } else {
                        $session->put('intend', url()->current());
                        $session->forget('lastActivity');
                        return redirect('/login')
                                ->with('status', 'Your session expired.');
                    }
                } else {
                    $session->put('lastActivity',time());
                }
            } else {
                $session->forget('lastActivity');
            }
        }
        return $next($request);
    }
}
