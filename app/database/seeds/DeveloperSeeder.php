<?php

/**
 * Description of DeveloperSeeder
 *
 * @author Ivan
 */
class DeveloperSeeder extends DatabaseSeeder {

    public function run() {
        
        $json = File::get(app_path() . "\database\seeds\json\developer.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            Developer::create([
                'name' => $object->name,
            ]);
        }
    }

}
