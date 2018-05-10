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
            // $table->string('username')->unique()->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('password')->default(bcrypt('secret'));
            $table->date('birthday')->nullable();
            $table->string('gender', 1)->nullable(); // M or F
            $table->string('mobile_phone')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('cedula')->nullable();
            $table->string('code')->unique()->nullable();
            $table->string('consultation_type')->nullable();
            $table->timestamp('lastaccess')->nullable();
            $table->boolean('enable')->default(true);
            $table->rememberToken()->nullable();
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
