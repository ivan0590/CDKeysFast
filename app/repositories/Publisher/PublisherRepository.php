<?php

namespace Repositories\Publisher;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Publisher as Publisher;

/**
 * Description of PublisherRepository
 *
 * @author Ivan
 */
class PublisherRepository extends BaseRepository implements PublisherRepositoryInterface {

    public function __construct(Publisher $model) {
        $this->model = $model;
    }

    public function getByName($name) {
        return Publisher::where('name', '=', $name)->first();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1) {

        $publishers = Publisher::select(['id', 'name']);

        \Paginator::setCurrentPage(($publishers->count() / $pagination) < $page ? ceil($publishers->count() / $pagination) : $page);

        return $publishers->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
