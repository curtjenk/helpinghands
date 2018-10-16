<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use App;
use Log;
use DB;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:user {--email="?"} {--name="?"}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $email = $this->option('email');
        $name = $this->option('name');
        $user = App\User::where('email', $email)->first();
        if ($user) {
            dump("----- User Already Exists ------ ");
            dump($email);
            dump($name);
            die();
        }


        DB::transaction(function() use($name, $email){
            $org = App\Organization::find(3); //Legacy Builders
            $role = App\Role::find(4); //Member
            $user = App\User::create([
                'password'=>bcrypt($email),
                'name'=>ucwords($name),
                'email'=>$email,
                'homephone'=>null,
                'mobilephone'=>null,
                'opt_receive_evite'=>true,
                'opt_show_email'=>true,
                'opt_show_mobilephone'=>false,
                'opt_show_homephone'=>false,
            ]);
            DB::table('organization_user')->insert([
                'organization_id' => $org->id,
                'user_id' => $user->id,
                'role_id' => $role->id
            ]);
        });

    }
}
