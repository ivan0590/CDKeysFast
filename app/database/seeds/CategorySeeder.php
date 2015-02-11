<?php

/**
 * Description of CategorySeeder
 *
 * @author Ivan
 */
class CategorySeeder extends DatabaseSeeder {

    public function run() {
        for ($index = 1; $index <= 20; $index++) {
            Category::create([
                'name' => "categoryTest$index",
                'description' => "categoryTest$index",
                'icon_path' => "categoryTest$index"]);
        }
    }

}
