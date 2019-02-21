<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCourseIdToCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->integer('ascription_id')->unsigned()->default(1);
            $table->foreign('ascription_id')->references('id')->on('ascriptions');
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

// alter table courses drop index courses_slug_unique;
// ALTER TABLE courses ADD UNIQUE courses_unique_slug_ascription_id (slug, ascription_id);
