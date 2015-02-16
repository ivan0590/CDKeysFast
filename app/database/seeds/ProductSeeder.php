<?php

/**
 * Description of ProductSeeder
 *
 * @author Ivan
 */
class ProductSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 100; $index++) {

            //Número del 1 al 20 que cada 20 valores se reinicia a 1
            $foreignIndex = $index - (20 * floor(($index - 1) / 20));
            
            $product = Product::create([
                        'price' => $index,
                        'discount' => $index <= 25 || ($index > 50 && $index <= 75) ? $index : null,
                        'stock' => $index,
                        'highlighted' => $index <= 50,
                        'launch_date' => new DateTime(" - $index days"),
                        'singleplayer' => true,
                        'multiplayer' => true,
                        'cooperative' => true,
                        'game_id' => $foreignIndex,
                        'platform_id' => ceil($index / 20),
                        'publisher_id' => $foreignIndex
            ]);


            Language::find($foreignIndex)->products()->save($product, ['type' => 'text']);
            Language::find($foreignIndex)->products()->save($product, ['type' => 'audio']);

            Developer::find($foreignIndex)->products()->save($product);
        }
    }

}
