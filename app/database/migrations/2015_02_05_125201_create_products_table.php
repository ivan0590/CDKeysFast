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
            $table->decimal('price', 7, 2)->unsigned();
            $table->decimal('discount', 4, 2)->unsigned()->nullable();
            $table->integer('stock')->unsigned();
            $table->boolean('highlighted');
            $table->date('launch_date');
            $table->boolean('singleplayer');
            $table->boolean('multiplayer');
            $table->boolean('cooperative');
            $table->integer('game_id')->unsigned();
            $table->integer('platform_id')->unsigned();
            $table->integer('publisher_id')->unsigned();
            $table->timestamps();
            
            $table->unique(['game_id', 'platform_id']);
            $table->foreign('game_id')->references('id')->on('games');
            $table->foreign('platform_id')->references('id')->on('platforms');
            $table->foreign('publisher_id')->references('id')->on('publishers');
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
