<?php

/**
 * Description of AgerateSeeder
 *
 * @author Ivan
 */
class AgerateSeeder extends DatabaseSeeder {

    public function run() {

        $json = File::get(app_path() . "\database\seeds\json\agerate.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            Agerate::create([
                'name' => $object->name
            ]);
        }
    }

}
