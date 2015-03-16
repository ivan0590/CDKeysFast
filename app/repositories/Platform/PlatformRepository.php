<?php

namespace Repositories\Platform;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Platform as Platform;

/**
 * Description of PlatformRepository
 *
 * @author Ivan
 */
class PlatformRepository extends BaseRepository implements PlatformRepositoryInterface {

    public function __construct(Platform $model) {
        $this->model = $model;
    }

    public function getByName($name) {
        return Platform::where('name', '=', $name)->first();
    }

    public function exists($id) {
        return !Platform::where('id', '=', $id)->get()->isEmpty();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1) {

        $platforms = Platform::select(['id', 'name']);

        \Paginator::setCurrentPage(($platforms->count() / $pagination) < $page ? ceil($platforms->count() / $pagination) : $page);

        return $platforms->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
