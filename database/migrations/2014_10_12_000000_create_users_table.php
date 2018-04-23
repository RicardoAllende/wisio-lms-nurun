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
            $table->string('password')->nullable();
            $table->dateTime('birth_day')->nullable();
            $table->string('gender', 1)->nullable(); // M or F
            $table->string('mobile_phone')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('address')->nullable();
            $table->string('cedula')->nullable();
            $table->string('specialty')->nullable();
            $table->string('consultation_type')->nullable();
            $table->string('prefered_medical')->nullable();
            $table->string('code')->unique()->nullable(); // Código único
            // $table->string('type')->nullable();//Tipo de usuario
            $table->string('source')->nullable();
            $table->string('source_token')->nullable();
            $table->timestamp('lastaccess')->nullable();
            $table->boolean('enable')->nullable();
            $table->rememberToken()->nullable();
            $table->integer('attachment_id')->unsigned()->nullable();
            $table->foreign('attachment_id')->references('id')->on('attachments');
            // $table->string('photo')->nullable();
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
