<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductDiscussionChildrenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discussion_childs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_discussion_id')->constrained('product_discussions');
            $table->foreignId('user_id')->constrained('users');
            $table->longText('detail_answer');
            $table->integer('status')->default(1); // posted: 1, draft: 0
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
        Schema::drop('product_discussion_childs');
    }
}
