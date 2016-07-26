<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlockerCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blocker_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('blocker_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->text('comment', 500);
            $table->timestamps();
            $table->foreign('blocker_id')->references('id')->on('blockers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('blocker_comments');
    }
}
