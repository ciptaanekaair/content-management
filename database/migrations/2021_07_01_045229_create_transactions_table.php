<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('voucher_id')->constrained('vouchers');
            $table->foreignId('payment_code_id')->constrained('payment_codes');
            $table->string('transaction_code');
            $table->date('transaction_date');
            $table->integer('total_item');
            $table->float('total_price');
            $table->float('payment');
            $table->integer('status')->default(0); // complete payment: 1, not-complete: 0, shipping: 2
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
        Schema::drop('transactions');
    }
}
