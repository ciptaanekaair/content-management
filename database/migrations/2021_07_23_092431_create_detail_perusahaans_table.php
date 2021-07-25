<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailPerusahaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_perusahaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama_pt')->nullable();
            $table->text('alamat_pt')->nullable();
            $table->foreignId('kota_id')->constrained('kotas');
            $table->foreignId('provinsi_id')->constrained('provinsis');
            $table->string('telepon')->nullable();
            $table->string('fax')->nullable();
            $table->string('handphone')->nullable();
            $table->string('npwp')->nullable();
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
        Schema::dropIfExists('detail_perusahaans');
    }
}
