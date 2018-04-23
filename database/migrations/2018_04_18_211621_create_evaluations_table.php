<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->unsigned()->nullable();
            $table->string('name');
            $table->string('type');
            $table->string('description')->nullable();
            $table->string('minimum_score')->default(6);
            $table->integer('maximum_attemps')->nullable();
            $table->integer('attachment_id')->unsigned()->nullable();
            $table->foreign('attachment_id')->references('id')->on('attachments');
            $table->foreign('module_id')->references('id')->on('modules');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('evaluations');
    }
}
