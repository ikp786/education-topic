<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRattingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratting', function (Blueprint $table) {
            $table->bigIncrements('ratting_id');
            $table->unsignedBigInteger('video_id');
            $table->unsignedBigInteger('sender_id');
            $table->unsignedBigInteger('reciver_id');
            $table->Integer('ratting_star');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('sender_id')->references('user_id')->on('users');
            $table->foreign('reciver_id')->references('user_id')->on('users');
            $table->foreign('video_id')->references('video_id')->on('video');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratting');
    }
}
