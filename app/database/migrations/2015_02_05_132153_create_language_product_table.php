<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageProductTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('language_product', function ($table) {
            $table->increments('id');
            $table->integer('product_id')->unsigned();
            $table->integer('language_id')->unsigned();
            $table->enum('type', ['audio', 'text']);
            
            $table->unique(['product_id', 'language_id', 'type']);
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('language_id')->references('id')->on('languages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('language_product');
    }

}
