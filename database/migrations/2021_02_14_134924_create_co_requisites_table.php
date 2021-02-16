<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoRequisitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_requisites', function (Blueprint $table) {
            $table->uuid('uuid')->unique();
            $table->uuid('semester_course_uuid');
            $table->uuid('course_uuid');

            $table->foreign('semester_course_uuid')
                ->references('uuid')
                ->on('semester_courses');

            $table->foreign('course_uuid')
                ->references('uuid')
                ->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('co_requisites');
    }
}
