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
            $table->text('description')->nullable();
            $table->text('thumbnail_image_path')->nullable();
            $table->text('offer_image_path')->nullable();
            $table->integer('agerate_id')->unsigned()->nullable();
            $table->integer('category_id')->unsigned()->nullable();
            $table->timestamps();
            
            $table->foreign('agerate_id')->references('id')->on('agerates')->onDelete('set null');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
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
