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
            $table->longtext('description_text')->nullable();
            $table->date('date_start')->nullable();
            $table->date('date_end')->nullable();
            $table->json('time_start')->nullable();
            $table->json('time_end')->nullable();
            $table->string('cost')->nullable();
            $table->datetime('evite_sent')->nullable();
            $table->integer('status_id')->unsigned()->nullable();
            $table->integer('event_type_id')->unsigned()->nullable();
            $table->string('signup_limit')->unsigned()->nullable();
            $table->integer('updated_user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('event_type_id')->references('id')->on('event_types');
            $table->foreign('team_id')->references('id')->on('teams');
            $table->foreign('organization_id')->references('id')->on('organizations');
        });
        DB::statement("ALTER TABLE events ALTER COLUMN subject TYPE CITEXT");
        DB::statement("ALTER TABLE events ALTER COLUMN description TYPE CITEXT");
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
