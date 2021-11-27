<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuestionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_question', function (Blueprint $table) {
            $table->bigIncrements('question_id');
            $table->unsignedBigInteger('exam_head_id');
            $table->string('question_title',100);
            $table->string('answer_a',50);
            $table->string('answer_b',50);
            $table->string('answer_c',50);
            $table->string('answer_d',50);
            $table->string('right_answer',10);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('exam_head_id')->references('exam_head_id')->on('exam_head');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('exam_question');
    }
}
