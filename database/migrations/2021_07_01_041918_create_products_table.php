<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories');
            $table->string('product_code');
            $table->string('product_name');
            $table->longText('product_description');
            $table->string('product_images');
            $table->float('product_price');
            $table->float('product_commision');
            $table->integer('product_stock');
            $table->integer('status')->default(1); // publish: 1, draft: 0
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
        Schema::drop('products');
    }
}
