<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInvitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invites', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email')->nullable();
            $table->boolean('subitus_tracking')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('company')->nullable();
            $table->string('url')->nullable();
            $table->integer('ascription_id')->unsigned()->nullable();
            $table->foreign('ascription_id')->references('id')->on('ascriptions');
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
        Schema::dropIfExists('invites');
    }
}
