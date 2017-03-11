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
            'email' => 'curtjenk@gmail.com',
            'password' => bcrypt('Cornerstone111'),
            'organization_id' => $org1,
            'role_id' => App\Role::where('name', 'Super User')->pluck('id')->first(),
        ]);
        //Add other test users;

        DB::table('users')->insertGetId([
            'name' => 'Test Admin',
            'email' => 'tadmin@helpinghands.com',
            'password' => bcrypt('123123'),
            'organization_id' => 1,
            'role_id' => App\Role::where('name', 'Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org Admin',
            'email' => 'torgadmin@helpinghands.com',
            'password' => bcrypt('123123'),
            'organization_id' => 1,
            'role_id' => App\Role::where('name', 'Organization Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org User',
            'email' => 'torguser@helpinghands.com',
            'password' => bcrypt('123123'),
            'organization_id' => 1,
            'role_id' => App\Role::where('name', 'Organization User')->pluck('id')->first(),
        ]);
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
            'email' => 'torgadmin2@helpinghands.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org2,
            'role_id' => App\Role::where('name', 'Organization Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org 2 User',
            'email' => 'torguser2@helpinghands.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org2,
            'role_id' => App\Role::where('name', 'Organization User')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org 3 Admin',
            'email' => 'torgadmin3@helpinghands.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org3,
            'role_id' => App\Role::where('name', 'Organization Admin')->pluck('id')->first(),
        ]);
        DB::table('users')->insertGetId([
            'name' => 'Test Org 3 User',
            'email' => 'torguser3@helpinghands.com',
            'password' => bcrypt('123123'),
            'organization_id' => $org3,
            'role_id' => App\Role::where('name', 'Organization User')->pluck('id')->first(),
        ]);
    }
}
