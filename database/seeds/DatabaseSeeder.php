<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // $this->call(UsersTableSeeder::class);
        $org1 = DB::table('organizations')->insertGetId([
            'name'=>'Cornerstone Baptist Church',
             'city'=>'Lithia Springs',
             'state'=>'Georgia'
        ]);
        DB::table('users')->insert([
            'name' => 'Legacy Builder',
            'email' => 'curtjenk@comcast.net',
            'password' => bcrypt('abc123'),
            'organization_id' => $org1,
            'opt_receive_evite' => false,
            'role_id' => App\Role::where('name', 'Super User')->pluck('id')->first(),
        ]);
        //Add other test users;

        DB::table('users')->insertGetId([
            'name' => 'Test Admin',
            'email' => 'tadmin@hh.com',
            'password' => bcrypt('123123'),
            'organization_id' => 1,
            'opt_receive_evite' => false,
            'role_id' => App\Role::where('name', 'Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org Admin',
            'email' => 'torgadmin@hh.com',
            'password' => bcrypt('123123'),
            'organization_id' => 1,
            'opt_receive_evite' => false,
            'role_id' => App\Role::where('name', 'Organization Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org User',
            'email' => 'curtjenk@gmail.com',
            'password' => bcrypt('123123'),
            'organization_id' => 1,
            'opt_receive_evite' => true,
            'role_id' => App\Role::where('name', 'Organization User')->pluck('id')->first(),
        ]);
        for ($x=1; $x<3; $x++) {
            DB::table('users')->insertGetId([
                'name' => 'Test Org User '. $x,
                'email' => 'curtjenk@gmail.com'.$x,
                'password' => bcrypt('123123'),
                'organization_id' => 1,
                'opt_receive_evite' => true,
                'role_id' => App\Role::where('name', 'Organization User')->pluck('id')->first(),
            ]);
        }
        $org2 = DB::table('organizations')->insertGetId([
            'name'=>'Organization 2',
            'city'=>'Hiram',
            'state'=>'Georgia'
        ]);
        $org3 = DB::table('organizations')->insertGetId([
            'name'=>'Organization 3',
            'city'=>'Birmingham',
            'state'=>'AL'
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org 2 Admin',
            'email' => 'torgadmin2@hh.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org2,
            'role_id' => App\Role::where('name', 'Organization Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org 2 User',
            'email' => 'torguser2@hh.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org2,
            'role_id' => App\Role::where('name', 'Organization User')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org 3 Admin',
            'email' => 'torgadmin3@hh.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org3,
            'role_id' => App\Role::where('name', 'Organization Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org 3 User',
            'email' => 'torguser3@hh.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org3,
            'role_id' => App\Role::where('name', 'Organization User')->pluck('id')->first(),
        ]);
    }
}
