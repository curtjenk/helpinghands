<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('permissions')->insert([
            ['name'=>'Create user'],
            ['name'=>'Delete user'],
            ['name'=>'Show user'],
            ['name'=>'Update user'],
            ['name'=>'List users'],

            ['name'=>'Create organization'],
            ['name'=>'Delete organization'],
            ['name'=>'Show organization'],
            ['name'=>'Update organization'],
            ['name'=>'List organizations'],

            ['name'=>'Create ticket'],
            ['name'=>'Delete ticket'],
            ['name'=>'Show ticket'],
            ['name'=>'Update ticket'],
            ['name'=>'List tickets'],

        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('permissions')->delete();
    }
}
