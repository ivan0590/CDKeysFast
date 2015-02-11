<?php

/**
 * Description of PublisherSeeder
 *
 * @author Ivan
 */
class PublisherSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 20; $index++) {
            Publisher::create(['name' => "publisherTest$index"]);
        }
    }

}
