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
            $table->integer('game_id')->unsigned()->nullable();
            $table->integer('platform_id')->unsigned()->nullable();
            $table->integer('publisher_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->unique(['game_id', 'platform_id']);
            $table->foreign('game_id')->references('id')->on('games')->onDelete('set null');
            $table->foreign('platform_id')->references('id')->on('platforms')->onDelete('set null');
            $table->foreign('publisher_id')->references('id')->on('publishers')->onDelete('set null');
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
