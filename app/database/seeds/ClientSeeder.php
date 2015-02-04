<?php

/**
 * Description of ClientSeeder
 *
 * @author Ivan
 */
class ClientSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 5; $index++) {
            Client::create(['birthdate' => new DateTime('05/01/1990'), 'dni' => str_repeat($index, 8).'A']);
            
        }
    }

}
