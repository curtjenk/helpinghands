<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->integer('organization_id')->unsigned();
            $table->integer('team_id')->unsigned()->nullable();
            $table->string('subject');
            $table->longtext('description')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->decimal('cost',5,2)->nullable()->default(0.00);
            $table->date('evite_sent')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('event_type_id')->unsigned()->nullable();
            $table->integer('signup_limit')->unsigned()->nullable();
            $table->integer('updated_user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('event_type_id')->references('id')->on('event_types');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
