<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttachmentModuleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attachment_module', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('module_id')->unsigned();
            $table->integer('attachment_id')->unsigned();
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('attachment_module');
    }
}
