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
            $table->foreignId('payment_code_id')->nullable()->constrained('payment_codes')->onDelete('cascade');
            $table->foreignId('voucher_id')->nullable()->constrained('vouchers')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('transaction_code');
            $table->date('transaction_date');
            $table->bigInteger('total_item');
            $table->bigInteger('total_price');
            $table->bigInteger('discount')->nullable();
            $table->bigInteger('price_after_discount');
            $table->bigInteger('pajak_ppn')->nullable();
            $table->bigInteger('sub_total_price');
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
