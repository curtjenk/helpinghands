<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('mobilephone',64)->nullable();
            $table->string('homephone',64)->nullable();
            // $table->integer('organization_id')->nullable();
            $table->integer('birth_mm')->nullable();
            $table->integer('birth_dd')->nullable();
            $table->integer('birth_yyyy')->nullable();
            $table->string('avatar_filename')->nullable();
            $table->boolean('admin')->nullable()->default(false);
            $table->boolean('active')->nullable()->default(true);
            $table->boolean('opt_show_email')->nullable()->default(true);
            $table->boolean('opt_receive_evite')->nullable()->default(true);
            $table->boolean('opt_show_mobilephone')->nullable()->default(false);
            $table->boolean('opt_show_homephone')->nullable()->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::query("ALTER TABLE users ALTER COLUMN name TYPE CITEXT");
        DB::query("ALTER TABLE users ALTER COLUMN nickname TYPE CITEXT");
        DB::query("ALTER TABLE users ALTER COLUMN email TYPE CITEXT");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
