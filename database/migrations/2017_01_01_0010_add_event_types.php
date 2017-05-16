<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEventTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        DB::table('event_types')->insert([
            ['name'=>'LearnTrainGrow', 'description'=>'Learn, Train & Grow'],
            ['name'=>'Fellowship', 'description'=>"Men's Events/Fellowships"],
            ['name'=>'Service', 'description'=>'Service Opportunity'],
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
