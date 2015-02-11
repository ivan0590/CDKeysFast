<?php

/**
 * Description of GameSeeder
 *
 * @author Ivan
 */
class GameSeeder extends DatabaseSeeder {

    public function run() {
        for ($index = 1; $index <= 20; $index++) {

            Game::create([
                'name' => "gameTest$index",
                'description' => "gameTest$index",
                'thumbnail_image_path' => "http://placehold.it/242x200",
                'offer_image_path' => "http://placehold.it/854x480",
                'agerate_id' => $index,
                'category_id' => $index]);
        }
    }

}
