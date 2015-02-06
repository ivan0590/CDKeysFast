<?php

/**
 * Description of AgerateSeeder
 *
 * @author Ivan
 */
class AgerateSeeder extends DatabaseSeeder {

    public function run() {
        for ($index = 1; $index <= 5; $index++) {
            Agerate::create(['name' => "agerateTest$index"]);
        }
    }

}
