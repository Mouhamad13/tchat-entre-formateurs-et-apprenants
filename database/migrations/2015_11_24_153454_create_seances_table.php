<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('course_id');
            $table->string('classroom_id');
            $table->timestamp('start_hours');
            $table->timestamp('end_hours');
            $table->string('local');
            $table->unsignedInteger('absent'); // 0 = présent - 1 = absent
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses');
            //$table->foreign('classroom_id')->references('classrooms')->on('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('seances');
    }
}
