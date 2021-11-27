<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('user_id');
            $table->string('full_name',32);
            $table->string('email_address',50)->unique();
            $table->string('mobile_number',10)->unique();
            $table->string('intrest_id',50);
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('profession_id');
            $table->string('user_image',50);
            $table->string('college_name',100);
            $table->Integer('gender_id');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('language_id')->references('language_id')->on('language');
            $table->foreign('profession_id')->references('profession_id')->on('profession');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
