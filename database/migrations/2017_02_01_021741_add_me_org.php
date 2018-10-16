<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMeOrg extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('organizations')->insert([
            'name'=>'Ministry Engage',
            'parent_id'=>null,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);

        $orgCornerstone = DB::table('organizations')->insertGetId([
            'name'=>'Cornerstone Baptist Church',
            'parent_id'=>null,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);

        $orgLegBldchildToCornerstone = DB::table('organizations')->insertGetId([
            'name'=> "Legacy Builders Men's Ministry",
            'parent_id'=>$orgCornerstone,
            'city'=>'Lithia Springs',
            'state'=>'Georgia'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
