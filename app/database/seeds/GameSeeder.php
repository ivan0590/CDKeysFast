<?php

/**
 * Description of GameSeeder
 *
 * @author Ivan
 */
class GameSeeder extends DatabaseSeeder {

    public function run() {

        $json = File::get(app_path() . "\database\seeds\json\game.json");
        $data = json_decode($json);
        $gameOfferImageDir = Config::get('constants.GAME_OFFER_IMAGE_DIR') . '/';
        $gameThumbnailImageDir = Config::get('constants.GAME_THUMBNAIL_IMAGE_DIR'). '/';

        foreach ($data as $object) {
            Game::create([
                'name' => $object->name,
                'description' => $object->description,
                'offer_image_path' => $gameOfferImageDir  . $object->name . '.' . $object->offer_image_extension,
                'thumbnail_image_path' => $gameThumbnailImageDir  . $object->name . '.' . $object->thumbnail_image_extension,
                'category_id' => $object->category_id,
                'agerate_id' => $object->agerate_id
            ]);
        }
    }

}
