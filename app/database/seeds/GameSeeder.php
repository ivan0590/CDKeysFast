<?php

/**
 * Description of GameSeeder
 *
 * @author Ivan
 */
class GameSeeder extends DatabaseSeeder {

    public function run() {
        for ($index = 1; $index <= 5; $index++) {

            Game::create([
                'name' => "gameTest$index",
                'description' => "gameTest$index",
                'image_path' => "gameTest$index",
                'id_agerate' => $index,
                'id_category' => $index]);
        }
    }

}
