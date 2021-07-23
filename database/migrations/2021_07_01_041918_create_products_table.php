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
            $table->string('slug');
            $table->longText('product_description');
            $table->text('keywords')->nullable();
            $table->text('description_seo')->nullable();
            $table->string('product_images')->default('product-images/blank_product.png');
            $table->decimal('product_price', 16,0);
            $table->decimal('product_commision', 16,0)->nullable();
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
