<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet', function (Blueprint $table) {
            $table->bigIncrements('wallet_id');
            $table->unsignedBigInteger('user_id');
            $table->string('tran_amount',10);
            $table->Integer('tran_type')->default(910)->comment('909 = Debit, 910 = Cerdit');
            $table->Integer('wallet_type')->default(810)->comment('808 = Sent, 809 = Recived, 810 = Purchased');
            $table->string('stripe_txn_id',50)->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('user_id')->references('user_id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet');
    }
}
