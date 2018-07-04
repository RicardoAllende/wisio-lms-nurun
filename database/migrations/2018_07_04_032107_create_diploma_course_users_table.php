<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiplomaCourseUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diploma_course_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('diploma_course_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->float('score', 10,5)->nullable();
            $table->boolean('status')->default(false);
            $table->foreign('diploma_course_id')->references('id')->on('diploma_courses');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('diploma_course_users');
    }
}
