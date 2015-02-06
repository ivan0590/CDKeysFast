<?php

/**
 * Description of ProductSeeder
 *
 * @author Ivan
 */
class ProductSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 5; $index++) {
            $product = Product::create([
                        'price' => $index,
                        'discount' => $index,
                        'stock' => $index,
                        'highlighted' => false,
                        'launch_date' => new DateTime('06/02/2015'),
                        'singleplayer' => true,
                        'multiplayer' => true,
                        'cooperative' => true,
                        'id_game' => $index,
                        'id_platform' => $index,
                        'id_publisher' => $index,
            ]);
            
            
            Language::find($index)->products()->save($product, ['type' => 'text']);
            Language::find($index)->products()->save($product, ['type' => 'audio']);

            Developer::find($index)->products()->save($product);
        }
    }

}
