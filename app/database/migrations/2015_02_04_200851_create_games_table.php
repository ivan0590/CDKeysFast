<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        
        Schema::create('games', function ($table) {
            $table->increments('id');
            $table->text('name')->inique();
            $table->text('description');
            $table->text('image_path');
            $table->integer('id_agerate')->unsigned();
            $table->integer('id_category')->unsigned();
            $table->timestamps();
            
            $table->foreign('id_agerate')->references('id')->on('agerates');
            $table->foreign('id_category')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::drop('games');
    }

}
