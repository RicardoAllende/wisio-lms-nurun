<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertSpecialtyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_specialty', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expert_id')->unsigned();
            $table->integer('specialty_id')->unsigned();
            $table->foreign('expert_id')->references('id')->on('experts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('specialty_id')->references('id')->on('specialties')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('expert_specialty');
    }
}
