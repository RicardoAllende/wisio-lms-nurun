<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('date_start')->nullable();
            $table->dateTime('date_end')->nullable();
            // $table->string('featured_image')->nullable();
            $table->string('icon')->nullable();
            $table->boolean('featured')->nullable();
            $table->integer('weight')->nullable();
            // $table->integer('category_id')->unsigned()->nullable();;
            // $table->enum('difficulty',['básico','intermedio','avanzado','experto']);
            $table->string('difficulty')->nullable();;
            $table->boolean('has_constancy')->default(false);
            $table->integer('length')->nullable();;
            $table->integer('attachment_id')->unsigned()->nullable();
            $table->foreign('attachment_id')->references('id')->on('attachments');
            // $table->foreign('category_id')->references('id')->on('categories');
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
        Schema::dropIfExists('courses');
    }
}
