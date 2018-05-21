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
            $table->string('name');
            $table->string('type', 10);
            $table->string('description')->nullable();
            $table->float('minimum_score', 10, 5)->default(8);
            $table->float('maximum_score', 10, 5)->default(10);
            $table->integer('maximum_attemps')->default(2);
            /**
             * An evaluation can belong to a module or ascription in the v2,
             * only one of them must be filled for each evaluation.
             */
            $table->integer('module_id')->unsigned()->nullable();
            $table->integer('ascription_id')->unsigned()->nullable();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ascription_id')->references('id')->on('ascriptions')->onDelete('cascade')->onUpdate('cascade');
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
