<?php

namespace Repositories\Publisher;

use \Publisher as Publisher;

/**
 * Description of PublisherRepository
 *
 * @author Ivan
 */
class PublisherRepository implements PublisherRepositoryInterface {

    public function find($id) {
        return Publisher::find($id);
    }

    public function create($data) {

        \Eloquent::unguard();

        $publisher = new Publisher($data);
        $result = $publisher->save();

        \Eloquent::reguard();

        return $result;
    }

    public function update($id, $data) {

        \Eloquent::unguard();

        $result = Publisher::find($id)->update($data);

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {
        
        return Publisher::find($id)->delete();
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
