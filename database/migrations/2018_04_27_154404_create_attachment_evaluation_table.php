<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_evaluation', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('evaluation_id')->unsigned();
            $table->integer('attachment_id')->unsigned();
            $table->foreign('evaluation_id')->references('id')->on('evaluations')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('attachment_evaluation');
    }
}
