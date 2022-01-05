<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->unsignedInteger('for');
            $table->unsignedInteger('course_id')->nullable();
            $table->unsignedInteger('seance_id')->nullable();
            $table->unsignedInteger('work_id')->nullable();
            $table->unsignedInteger('test_id')->nullable();
            $table->unsignedInteger('message_id')->nullable();
            $table->unsignedInteger('user_id')->nullable();
            $table->unsignedInteger('context');
            $table->unsignedInteger('seen')->default(0);
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
        Schema::drop('notifications');
    }
}
