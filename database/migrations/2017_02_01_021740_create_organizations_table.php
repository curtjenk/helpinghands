<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organizations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address1', 255)->nullable();
            $table->string('address2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('zipcode', 32)->nullable();
            $table->string('state')->nullable();
            $table->string('phone', 63)->nullable();
            $table->integer('updated_user_id')->unsigned();
            $table->timestamps();

            $table->unique(['name']);

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
        //DB::statement('drop table organizations cascade');
        //Schema::dropIfExists('users');
        Schema::dropIfExists('organizations');
    }
}
