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
        DB::table('teams')->insertGetId([
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
        $user = DB::table('users')->insertGetId([
            'name' => 'Legacy Builder',
            'email' => 'cj@cj.net',
            'password' => bcrypt('abc123'),
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$childOrg1,
            'user_id'=>$user,
            'role_id'=>App\Role::where('name','Admin')->pluck('id')->first()
        ]);
        //Add other test users;


    }
}
