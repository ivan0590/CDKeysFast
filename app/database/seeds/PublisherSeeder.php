<?php

/**
 * Description of PublisherSeeder
 *
 * @author Ivan
 */
class PublisherSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 40; $index++) {
            Publisher::create(['name' => "publisherTest$index"]);
        }
        
        $json = File::get(app_path() . "\database\seeds\json\publisher.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            Publisher::create([
                'name' => $object->name,
            ]);
        }
    }

}
