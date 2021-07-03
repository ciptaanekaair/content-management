<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('website_title');
            $table->string('website_logo');
            $table->longText('website_description');
            $table->string('midtrans_client_token');
            $table->string('midtrans_server_token');
            $table->integer('status')->default(1); // active; 1, maintenance: 2, construction 3.
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
        Schema::drop('general_settings');
    }
}
