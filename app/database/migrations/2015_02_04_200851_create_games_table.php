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
            $table->text('thumbnail_image_path');
            $table->text('offer_image_path');
            $table->integer('agerate_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->timestamps();
            
            $table->foreign('agerate_id')->references('id')->on('agerates');
            $table->foreign('category_id')->references('id')->on('categories');
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
