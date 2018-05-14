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
            $table->string('slug')->unique()->nullable();
            $table->string('description');
            $table->boolean('has_constancy')->default(false); // If it's a 'diplomado'
            $table->boolean('is_pharmacy')->default(false); // For special actions
            $table->integer('maximum_attemps')->default(2)->unsigned(); // 0 means there's no restriction, it's for a diplomat
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
