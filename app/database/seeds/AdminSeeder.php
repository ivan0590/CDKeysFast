<?php

/**
 * Description of AdminSeeder
 *
 * @author Ivan
 */
class AdminSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 5; $index++) {
            Admin::create([]);
        }
    }

}
