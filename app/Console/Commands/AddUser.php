<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use App;
use Log;

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
        $role_id = App\Role::where('name','Organization User')->first()->id;

        try {
            App\User::create([
                'password'=>bcrypt($email),
                'name'=>ucwords($name),
                'email'=>$email,
                'homephone'=>null,
                'mobilephone'=>null,
                'role_id'=>$role_id,
                'organization_id'=>1,
                'opt_receive_evite'=>true,
                'opt_show_email'=>true,
                'opt_show_mobilephone'=>false,
                'opt_show_homephone'=>false,
            ]);

        } catch (QueryException $qe) {
            echo print_r($qe->getMessage, true);
        }

    }
}
