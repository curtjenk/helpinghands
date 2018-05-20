<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Organization;
use App\Role;
use DB;
use Mail;
use App\Mail\EmailVerification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $email =  strtolower($data['email']);
        $user = User::create([
            'name' => $data['name'],
            'email' => $email,
            'password' => bcrypt($data['password']),
            'verify_email_token' => base64_encode($email),
        ]);

        $org0 = Organization::where('name','Ministry Engage')
            ->pluck('id')->first();
        $visitor = Role::where('name','Visitor')
            ->pluck('id')->first();

        DB::table('organization_user')->insert([
            'organization_id'=>$org0,
            'user_id'=>$user->id,
            'role_id'=>$visitor
        ]);

        $this->redirectTo = "/member/$user->id/edit";

        return $user;
    }

    /**** Overrides register() in RegistersUser.php (trait)
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        Mail::to($user)->queue(new EmailVerification($user));

        return view('verification');

    }

    /**
     * Handle a registration request for the application.
     *
     * @param $token
     * @return \Illuminate\Http\Response
     */
    public function verify($token)
    {
        $user = User::where('verify_email_token', $token)->first();
        $user->verified = 1;

        if($user->save()){
            return view('emailconfirm', ['user' => $user]);
        }
    }
}
