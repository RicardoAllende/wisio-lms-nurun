<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ascriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('description')->nullable();
            $table->boolean('has_constancy')->default(false); // If it's a 'diplomado'
            $table->boolean('is_pharmacy')->default(false);
            $table->boolean('is_main_ascription')->default(false); // Academia-mc, or paec méxico. It's public
            $table->integer('maximum_attemps')->default(2)->unsigned(); // 0 means there's no restriction, it's for a 'diplomado'
            $table->integer('minimum_score')->unsigned()->default(8);
            $table->boolean('enabled')->default(true);
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
        Schema::dropIfExists('ascriptions');
    }
}
