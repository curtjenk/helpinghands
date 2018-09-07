<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGrillvotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grillvotes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('judge_id')->unsigned();
            $table->integer('contestant_id')->unsigned();
            $table->integer('taste')->unsigned()->nullable()->default(0);
            $table->integer('texture')->unsigned()->nullable()->default(0);
            $table->integer('appearance')->unsigned()->nullable()->default(0);

            $table->foreign('judge_id')
                  ->references('id')->on('grillusers');

            $table->foreign('contestant_id')
                  ->references('id')->on('grillusers');
          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('grillvotes');
    }
}
