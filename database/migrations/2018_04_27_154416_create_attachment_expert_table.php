<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentExpertTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_expert', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('expert_id')->unsigned();
            $table->integer('attachment_id')->unsigned();
            $table->foreign('expert_id')->references('id')->on('experts')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('attachment_expert');
    }
}
