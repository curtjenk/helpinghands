<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_files', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('team_id')->unsigned();
            $table->string('description')->nullable();
            $table->string('original_filename');
            $table->string('mimetype');
            $table->string('path');
            $table->integer('size');

            $table->foreign('event_id')
                  ->references('id')->on('events')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_files');
    }
}
