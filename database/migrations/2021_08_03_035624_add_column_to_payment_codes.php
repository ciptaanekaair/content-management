<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToPaymentCodes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payment_codes', function (Blueprint $table) {
            $table->longText('cara_bayar')
                    ->after('cabang')
                    ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_codes', function (Blueprint $table) {
            $table->dropColumn('cara_bayar');
        });
    }
}
