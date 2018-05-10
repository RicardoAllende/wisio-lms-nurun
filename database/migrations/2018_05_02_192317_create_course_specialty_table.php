<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseSpecialtyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_specialty', function (Blueprint $table) {
            $table->integer('specialty_id')->unsigned();
            $table->integer('course_id')->unsigned();
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_specialty');
    }
}
