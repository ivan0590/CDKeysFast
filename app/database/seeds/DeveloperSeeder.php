<?php

/**
 * Description of DeveloperSeeder
 *
 * @author Ivan
 */
class DeveloperSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 40; $index++) {
            Developer::create(['name' => "developerTest$index"]);
        }
        
        $json = File::get(app_path() . "\database\seeds\json\developer.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            Developer::create([
                'name' => $object->name,
            ]);
        }
    }

}
