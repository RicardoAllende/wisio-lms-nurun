<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseUserTryIdToEvaluationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('evaluation_user', function (Blueprint $table) {
            $table->integer('course_user_try_id')->unsigned();
            $table->foreign('course_user_try_id')->references('id')->on('course_user_tries')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('evaluation_user', function (Blueprint $table) {
            $table->dropForeign('course_user_try_id');
        });
    }
}
