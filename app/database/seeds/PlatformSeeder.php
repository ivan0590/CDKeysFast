<?php

/**
 * Description of PlatformSeeder
 *
 * @author Ivan
 */
class PlatformSeeder extends DatabaseSeeder {

    public function run() {

        $json = File::get(app_path() . "\database\seeds\json\platform.json");
        $data = json_decode($json);
        $platformIconDir = Config::get('constants.PLATFORM_ICON_DIR');

        foreach ($data as $object) {
            Platform::create([
                'name' => $object->name,
                'description' => $object->description,
                'icon_path' => $platformIconDir . $object->icon_path,
            ]);
        }
    }

}
