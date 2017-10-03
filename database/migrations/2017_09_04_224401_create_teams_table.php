<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teams', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('organization_id')->unsigned();
            $table->string('name');
            $table->longtext('description')->nullable();
            $table->integer('updated_user_id')->unsigned()->nullable();
            $table->timestamps();

            $table->unique(['organization_id', 'name']);

            $table->foreign('organization_id')
                  ->references('id')->on('organizations')
                  ->onDelete('cascade');
            $table->foreign('updated_user_id')
                  ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('teams');
    }
}
