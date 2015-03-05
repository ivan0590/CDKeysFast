<?php

namespace Repositories\Language;

use \Language as Language;

/**
 * Description of LanguageRepository
 *
 * @author Ivan
 */
class LanguageRepository implements LanguageRepositoryInterface {

    public function find($id) {
        return Language::find($id);
    }

    public function create($data) {

        \Eloquent::unguard();

        $language = new Language($data);
        $result = $language->save();

        \Eloquent::reguard();

        return $result;
    }

    public function update($id, $data) {

        \Eloquent::unguard();

        $result = Language::find($id)->update($data);

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {
        return Language::find($id)->delete();
    }

    public function getByName($name) {
        return Language::where('name', '=', $name)->first();
    }

}
