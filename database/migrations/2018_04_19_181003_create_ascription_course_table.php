<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAscriptionCourseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ascription_course', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ascription_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->foreign('ascription_id')->references('id')->on('ascriptions');
            $table->foreign('course_id')->references('id')->on('courses');
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
        Schema::dropIfExists('ascription_courses');
    }
}
