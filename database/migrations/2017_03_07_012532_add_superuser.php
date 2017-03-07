<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSuperuser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('users')->insert([
            'name' => 'Legacy Builder',
            'email' => 'curtjenk@gmail.com',
            'password' => bcrypt('Cornerstone111'),
            'role_id' => App\Role::where('name', 'Super User')->pluck('id')->first(),

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
