<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('products', function ($table) {
            $table->increments('id');
            $table->decimal('price', 5, 2)->unsigned();
            $table->decimal('discount', 2, 2)->unsigned();
            $table->integer('stock')->unsigned();
            $table->boolean('highlighted');
            $table->date('launch_date');
            $table->boolean('singleplayer');
            $table->boolean('multiplayer');
            $table->boolean('cooperative');
            $table->integer('id_game')->unsigned();
            $table->integer('id_platform')->unsigned();
            $table->integer('id_publisher')->unsigned();
            $table->timestamps();
            
            $table->unique(['id_game', 'id_platform']);
            $table->foreign('id_game')->references('id')->on('games');
            $table->foreign('id_platform')->references('id')->on('platforms');
            $table->foreign('id_publisher')->references('id')->on('publishers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('products');
    }

}
