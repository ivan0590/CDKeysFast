<?php

namespace Repositories\Agerate;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;

use \Agerate as Agerate;

/**
 * Description of AgerateRepository
 *
 * @author Ivan
 */
class AgerateRepository extends BaseRepository implements AgerateRepositoryInterface {

    public function __construct(Agerate $model) {
        $this->model = $model;
    }
    
    public function getByName($name) {
        return Agerate::where('name', '=', $name)->first();
    }

}
