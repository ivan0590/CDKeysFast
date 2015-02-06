<?php

/**
 * Description of LanguageSeeder
 *
 * @author Ivan
 */
class LanguageSeeder extends DatabaseSeeder {

    public function run() {

        for ($index = 1; $index <= 5; $index++) {
            Language::create(['name' => "languageTest$index"]);
        }
    }

}
