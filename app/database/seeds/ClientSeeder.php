<?php

/**
 * Description of ClientSeeder
 *
 * @author Ivan
 */
class ClientSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 5; $index++) {
            Client::create([]);
            
        }
    }

}
