<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nama_pt');
            $table->text('alamat');
            $table->foreignId('kelurahan_id')->constrained('kelurahans')->nullable();
            $table->foreignId('kecamatan_id')->constrained('kecamatans')->nullable();
            $table->foreignId('provinsi_id')->constrained('provinsis')->nullable();
            $table->string('kode_pos');
            $table->string('telepon');
            $table->string('handphone');
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
        Schema::drop('user_details');
    }
}
