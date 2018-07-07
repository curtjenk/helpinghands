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
        //Create Organizations
        $ministryEngage = App\Organization::where('name','Ministry Engage')
            ->pluck('id')->first();

        $orgCornerstone = App\Organization::where('name', 'Cornerstone Baptist Church')
            ->pluck('id')->first();

        $orgLegBldchildToCornerstone = App\Organization::where('name', "Legacy Builders Men's Ministry")
            ->pluck('id')->first();

        $legacyBuildersTeam1 = DB::table('teams')->insertGetId([
            'name'=> "Fellowship",
            'organization_id'=>$orgLegBldchildToCornerstone,
            'description'=>'Responsibile for fellowship activities'
        ]);
        $orgCascadeUMC = DB::table('organizations')->insertGetId([
            'name'=>'Cascade United Methodist',
            'parent_id'=>null,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);

        //Create users
        $siteAdmin = DB::table('users')->insertGetId([
            'name' => 'Site',
            'email' => 'site@me.net',
            'verified' => true,
            'password' => Hash::make('iamTheManabc123'),
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$ministryEngage,
            'user_id'=>$siteAdmin,
            'role_id'=>App\Role::where('name','Site')->pluck('id')->first()
        ]);
        //Visitor user
        $visitor = DB::table('users')->insertGetId([
            'name' => 'Visitor',
            'email' => 'visitor@me.net',
            'verified' => true,
            'password' => Hash::make('abc123'),
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$ministryEngage,
            'user_id'=>$visitor,
            'role_id'=>App\Role::where('name','Visitor')->pluck('id')->first()
        ]);
        //TEST user 1
        $testUser1 =DB::table('users')->insertGetId([
            'name' => 'Test 1',
            'email' => 'curtjenk@gmail.com',
            'verified' => false,
            'password' => Hash::make('abc123'),
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$orgCornerstone,
            'user_id'=>$testUser1,
            'role_id'=>App\Role::where('name','Member')->pluck('id')->first()
        ]);
        //TEST user 2
        $testUser2 =DB::table('users')->insertGetId([
            'name' => 'Test 2',
            'email' => 'test2@me.net',
            'verified' => true,
            'password' => Hash::make('abc123'),
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$orgCornerstone,
            'user_id'=>$testUser2,
            'role_id'=>App\Role::where('name','Member')->pluck('id')->first()
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$orgLegBldchildToCornerstone,
            'user_id'=>$testUser2,
            'role_id'=>App\Role::where('name','Admin')->pluck('id')->first()
        ]);
        //TEST user 3
        $testUser3 =DB::table('users')->insertGetId([
            'name' => 'Test 3',
            'email' => 'test3@me.net',
            'verified' => true,
            'password' => Hash::make('abc123'),
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$orgLegBldchildToCornerstone,
            'user_id'=>$testUser3,
            'role_id'=>App\Role::where('name','Admin')->pluck('id')->first()
        ]);
        DB::table('team_user')->insert([
            'team_id'=>$legacyBuildersTeam1,
            'user_id'=>$testUser3,
            'role_id'=>App\Role::where('name','Lead')->pluck('id')->first()
        ]);

        //Everyone becomes a "Visitor" of the site by default
        DB::table('organization_user')->insert([
            'organization_id'=>$ministryEngage,
            'user_id'=>$testUser1,
            'role_id'=>App\Role::where('name','Visitor')->pluck('id')->first()
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$ministryEngage,
            'user_id'=>$testUser2,
            'role_id'=>App\Role::where('name','Visitor')->pluck('id')->first()
        ]);
        DB::table('organization_user')->insert([
            'organization_id'=>$ministryEngage,
            'user_id'=>$testUser3,
            'role_id'=>App\Role::where('name','Visitor')->pluck('id')->first()
        ]);
        //----------------------------



        //Add other test users;


    }
}
