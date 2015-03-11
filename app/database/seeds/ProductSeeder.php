<?php

/**
 * Description of ProductSeeder
 *
 * @author Ivan
 */
class ProductSeeder extends DatabaseSeeder {

    public function run() {

        $json = File::get(app_path() . "\database\seeds\json\product.json");
        $data = json_decode($json);

        foreach ($data as $object) {
            $product = Product::create([
                        'price' => $object->price,
                        'discount' => $object->discount,
                        'stock' => $object->stock,
                        'highlighted' => $object->highlighted,
                        'launch_date' => new DateTime($object->launch_date),
                        'singleplayer' => $object->singleplayer,
                        'multiplayer' => $object->multiplayer,
                        'cooperative' => $object->cooperative,
                        'game_id' => $object->game_id,
                        'platform_id' => $object->platform_id,
                        'publisher_id' => $object->publisher_id
            ]);

            foreach ($object->audio as $audio) {
                Language::find($audio)->products()->save($product, ['type' => 'audio']);
            }
            
            foreach ($object->text as $text) {
                Language::find($text)->products()->save($product, ['type' => 'text']);
            }
            
            foreach ($object->developers as $developer) {
                Developer::find($developer)->products()->save($product);
            }
        }
    }

}
