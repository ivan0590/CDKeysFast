<?php

/**
 * Description of LanguageSeeder
 *
 * @author Ivan
 */
class LanguageSeeder extends DatabaseSeeder {

    public function run() {
        
        $json = File::get(app_path() . "\database\seeds\json\language.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            Language::create([
                'name' => $object->name,
            ]);
        }
    }

}
