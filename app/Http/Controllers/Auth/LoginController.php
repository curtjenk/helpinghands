<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use App\Mail\EmailVerification;
use App;
use Hash;
use Mail;
use Log;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    /**
    * Get the needed authorization credentials from the request.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
    protected function credentials(Request $request)
    {
       return ['email' => $request->{$this->username()}, 'password' => $request->password, 'verified' => 1];
    }

    /** overrides AuthenticatesUsers.php
     *
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $msg = trans('auth.failed');
        $user = App\User::where('email', $request->email)->first();
        if (Hash::check($request->password, $user->password)) {
            if (!$user->verified) {
                $msg = trans('auth.failed_verifyemail');
                Mail::to($user)->queue(new EmailVerification($user, ['from'=>'login']));
                Log::debug("Request Email verification: ".$request->email);
            }
        }
        throw ValidationException::withMessages([
            $this->username() => [$msg],
        ]);
    }
}
