<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Evaluation;

class AlterEvaluationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Evaluation::whereNotNull('course_id')->delete();
        Schema::table('evaluations', function (Blueprint $table) {
            $table->integer('diploma_id')->unsigned()->nullable();
            $table->dropColumn('is_diplomat_evaluation');
            $table->dropForeign('evaluations_ibfk_1');
            $table->dropColumn('course_id');
            $table->foreign('diploma_id')->references('id')->on('diplomas')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
