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
            $table->string('username')->unique()->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->dateTime('birth_day')->nullable();
            $table->enum('sex',['male','female'])->nullable();
            $table->string('type')->nullable();
            $table->string('source')->nullable();
            $table->string('source_token')->nullable();
            $table->timestamp('lastaccess')->nullable();
            $table->boolean('enable')->nullable();
            $table->rememberToken()->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
