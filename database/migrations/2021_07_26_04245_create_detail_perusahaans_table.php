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
            $table->foreignId('provinsi_id')->nullable()->constrained('provinsis');
            $table->foreignId('kota_id')->nullable()->constrained('kotas');
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatans');
            $table->integer('kode_pos')->nullable();
            $table->string('telepon')->nullable();
            $table->string('fax')->nullable();
            $table->string('handphone')->nullable();
            $table->string('npwp')->nullable();
            $table->string('npwp_image')->nullable();
            $table->integer('status')->default(0);
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
