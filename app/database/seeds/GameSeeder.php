<?php

/**
 * Description of GameSeeder
 *
 * @author Ivan
 */
class GameSeeder extends DatabaseSeeder {

    public function run() {
        for ($index = 1; $index <= 200; $index++) {

            Game::create([
                'name' => "gameTest$index",
                'description' => "gameTest$index",
                'thumbnail_image_path' => "http://placehold.it/242x200&text=gameTest$index",
                'offer_image_path' => "http://placehold.it/854x480&text=gameTest$index",
                'agerate_id' => mt_rand(1, 20),
                'category_id' => mt_rand(1, 20)]);
        }
    }

}
