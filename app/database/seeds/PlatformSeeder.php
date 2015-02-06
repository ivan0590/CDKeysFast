<?php

/**
 * Description of PlatformSeeder
 *
 * @author Ivan
 */
class PlatformSeeder extends DatabaseSeeder {

    public function run() {
        for ($index = 1; $index <= 5; $index++) {
            
            Platform::create([
                'name' => "platformTest$index",
                'description' => "platformTest$index",
                'icon_path' => "platformTest$index"]);
        }
    }

}
