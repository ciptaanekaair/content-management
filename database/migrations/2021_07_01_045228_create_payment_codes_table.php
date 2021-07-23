<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_codes', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pembayaran');
            $table->string('nama_pembayaran');
            $table->string('nama_bank');
            $table->string('atas_nama_rekening');
            $table->string('nomor_rekening');
            $table->string('cabang');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('payment_codes');
    }
}
