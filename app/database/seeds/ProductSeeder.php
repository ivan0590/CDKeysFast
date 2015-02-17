<?php

/**
 * Description of ProductSeeder
 *
 * @author Ivan
 */
class ProductSeeder extends DatabaseSeeder {

    public function run() {

        $productsCount = 400;
        
        for ($index = 1; $index <= $productsCount; $index++) {

            $foreignIndex = ceil($index / ($productsCount / 40));
            
            $product = Product::create([
                        'price' => $index,
                        'discount' => mt_rand(0,1) ? mt_rand(1, 100) : null,
                        'stock' => $index,
                        'highlighted' => mt_rand(0,1),
                        'launch_date' => new DateTime(" - $index days"),
                        'singleplayer' => true,
                        'multiplayer' => true,
                        'cooperative' => true,
                        'game_id' => $index - (200 * floor(($index - 1) / 200)),
                        'platform_id' => ceil($index / ($productsCount / 5)),
                        'publisher_id' => $foreignIndex
            ]);


            Language::find($foreignIndex)->products()->save($product, ['type' => 'text']);
            Language::find($foreignIndex)->products()->save($product, ['type' => 'audio']);

            Developer::find($foreignIndex)->products()->save($product);
        }
    }

}
