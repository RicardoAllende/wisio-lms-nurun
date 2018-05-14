<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evaluation_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->float('score', 10,5)->nullable();
            $table->string('status')->default(config('constants.status.not_attemped'));
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('evaluation_users');
    }
}
