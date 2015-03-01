<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeveloperProductTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {

        Schema::create('developer_product', function ($table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('developer_id')->unsigned();

            $table->unique(['product_id', 'developer_id']);
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('developer_id')->references('id')->on('developers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('developer_product');
    }

}
