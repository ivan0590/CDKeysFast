<?php

namespace Repositories\Language;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Language as Language;

/**
 * Description of LanguageRepository
 *
 * @author Ivan
 */
class LanguageRepository extends BaseRepository implements LanguageRepositoryInterface {

    public function __construct(Language $model) {
        $this->model = $model;
    }

    public function getByName($name) {
        return Language::where('name', '=', $name)->first();
    }

}
