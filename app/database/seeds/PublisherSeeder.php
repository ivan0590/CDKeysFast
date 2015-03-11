<?php

/**
 * Description of PublisherSeeder
 *
 * @author Ivan
 */
class PublisherSeeder extends DatabaseSeeder {

    public function run() {

        $json = File::get(app_path() . "\database\seeds\json\publisher.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            Publisher::create([
                'name' => $object->name,
            ]);
        }
    }

}
