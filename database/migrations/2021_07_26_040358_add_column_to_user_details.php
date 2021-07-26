<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToUserDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->foreignId('kecamatan_id')
                ->after('kota_id')
                ->nullable()
                ->constrained('kecamatans');

            $table->foreignId('kelurahan_id')
                ->after('kecamatan_id')
                ->nullable()
                ->constrained('kelurahans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropColumn('kecamatan_id', 'kelurahan_id');
        });
    }
}
