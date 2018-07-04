<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiplomaCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diploma_courses', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('folio');
            $table->uuid('hash');
            $table->float('minimum_score', 10, 5)->default(8);
            $table->integer('maximum_diplomas')->default(1);
            $table->integer('course_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->foreign('course_id')->references('id')->on('courses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('diploma_template')->unsigned();
            $table->integer('certificate_template')->
            $table->string('code');
            $table->enum('type', ['diploma', 'conamege']);
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
        Schema::dropIfExists('diploma_courses');
    }
}
