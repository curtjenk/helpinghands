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
        $visitor = DB::table('users')->insertGetId([
            'name' => 'Visitor',
            'email' => 'visitor@me.net',
            'password' => Hash::make('abc123'),
        ]);
        $user = DB::table('users')->insertGetId([
            'name' => 'Site',
            'email' => 'site@me.net',
            'password' => Hash::make('abc123'),
        ]);

        $org0 = DB::table('organizations')->insertGetId([
            'name'=>'Ministry Engage',
            'parent_id'=>null,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$org0,
            'user_id'=>$user,
            'role_id'=>App\Role::where('name','Site')->pluck('id')->first()
        ]);
    
        $org1 = DB::table('organizations')->insertGetId([
            'name'=>'Cornerstone Baptist Church',
            'parent_id'=>null,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);
        $childOrg1 = DB::table('organizations')->insertGetId([
            'name'=> "Legacy Builders Men's Ministry",
            'parent_id'=>$org1,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);
        $team1 = DB::table('teams')->insertGetId([
            'name'=> "Fellowship",
            'organization_id'=>$childOrg1,
            'description'=>'Responsibile for fellowship activities'
        ]);
        $org2 = DB::table('organizations')->insertGetId([
            'name'=>'Cascade United Methodist',
            'parent_id'=>null,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);

        // DB::table('organization_user')->insert([
        //     'organization_id'=>$org1,
        //     'user_id'=>$user,
        //     'role_id'=>App\Role::where('name','Admin')->pluck('id')->first()
        // ]);
        // DB::table('organization_user')->insert([
        //     'organization_id'=>$childOrg1,
        //     'user_id'=>$user,
        //     'role_id'=>App\Role::where('name','Admin')->pluck('id')->first()
        // ]);
        // DB::table('team_user')->insert([
        //     'team_id'=>$team1,
        //     'user_id'=>$user,
        //     'role_id'=>App\Role::where('name','Lead')->pluck('id')->first()
        // ]);
        //Add other test users;


    }
}
