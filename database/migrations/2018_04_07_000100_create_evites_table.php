<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEviteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evites', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('team_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->smallinteger('num_invitations')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('event_id')
                  ->references('id')->on('events')
                  ->onDelete('cascade');

            $table->foreign('organization_id')
                  ->references('id')->on('organizations')
                  ->onDelete('cascade');

            $table->foreign('team_id')
                  ->references('id')->on('teams')
                  ->onDelete('cascade');

            $table->foreign('user_id')
                  ->references('id')->on('users')
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
        Schema::dropIfExists('evites');
    }
}
