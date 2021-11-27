<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('post_id');
            $table->unsignedBigInteger('user_id');
            $table->string('post_title',100);
            $table->longText('post_details');
            $table->string('meeting_url')->nullable();
            $table->unsignedBigInteger('subject_id');
            $table->unsignedBigInteger('language_id');
            $table->string('intrest_id',50);
            $table->string('post_file',50);
            $table->Integer('post_status')->default(105)->comment('105 = Open, 106 = Closed, 107 = Solved');
            $table->Integer('admin_status')->default(108)->comment('108 = Pending, 109 = Approved, 110 = Rejected');
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('user_id')->references('user_id')->on('users');
            $table->foreign('subject_id')->references('subject_id')->on('subject');
            $table->foreign('language_id')->references('language_id')->on('language');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
