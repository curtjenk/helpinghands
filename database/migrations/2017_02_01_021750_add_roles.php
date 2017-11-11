<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('roles')->insert([
            ['name'=>'Site', 'level'=>0],
    //The following apply to Organizations and Teams
            ['name'=>'Admin', 'level'=>1],
            ['name'=>'Lead', 'level'=>2],
            ['name'=>'Member', 'level'=>3],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
