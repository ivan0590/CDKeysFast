<?php

/**
 * Description of DeveloperSeeder
 *
 * @author Ivan
 */
class DeveloperSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 5; $index++) {
            Developer::create(['name' => "developerTest$index"]);
        }
    }

}
