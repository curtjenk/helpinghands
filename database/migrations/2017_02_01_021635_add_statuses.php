<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatuses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('statuses')->insert([
            ['name'=>'Open', 'description'=>'Open for signup'],
            ['name'=>'Closed', 'description'=>'Closed to signup. Event Complete or Cancelled'],
            ['name'=>'Hold', 'description'=>'Event on hold'],
            ['name'=>'Filled', 'description'=>'Maximum number of signups met'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('statuses');
    }
}
