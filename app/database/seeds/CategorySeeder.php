<?php

/**
 * Description of CategorySeeder
 *
 * @author Ivan
 */
class CategorySeeder extends DatabaseSeeder {

    public function run() {

        $json = File::get(app_path() . "\database\seeds\json\category.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            Category::create([
                'name' => $object->name,
                'description' => $object->description,
            ]);
        }
    }

}
