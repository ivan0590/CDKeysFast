<?php

namespace Repositories\Publisher;

use \Publisher as Publisher;

/**
 * Description of PublisherRepository
 *
 * @author Ivan
 */
class PublisherRepository implements PublisherRepositoryInterface {

    public function create($data) {

        \Eloquent::unguard();

        $publisher = new Publisher($data);
        $result = $publisher->save();

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {
        
        return Publisher::find($id)->delete();
    }
    
    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {

        $categories = Publisher::select(['id', 'name']);

        return $categories->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
