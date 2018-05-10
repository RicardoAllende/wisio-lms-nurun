<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAscriptionAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ascription_attachment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ascription_id')->unsigned();
            $table->integer('attachment_id')->unsigned();
            $table->foreign('ascription_id')->references('id')->on('ascriptions')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('ascription_attachment');
    }
}
