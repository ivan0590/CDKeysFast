<?php

namespace Repositories\Developer;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Developer as Developer;

/**
 * Description of DeveloperRepository
 *
 * @author Ivan
 */
class DeveloperRepository extends BaseRepository implements DeveloperRepositoryInterface {

    public function __construct(Developer $model) {
        $this->model = $model;
    }

    public function getByName($name) {
        return Developer::where('name', '=', $name)->first();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1) {

        $developers = Developer::select(['id', 'name']);

        \Paginator::setCurrentPage(($developers->count() / $pagination) < $page ? ceil($developers->count() / $pagination) : $page);

        return $developers->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
