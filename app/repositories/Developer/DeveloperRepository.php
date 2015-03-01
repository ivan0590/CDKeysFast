<?php

namespace Repositories\Developer;

use \Developer as Developer;

/**
 * Description of DeveloperRepository
 *
 * @author Ivan
 */
class DeveloperRepository implements DeveloperRepositoryInterface {

    public function create($data) {

        \Eloquent::unguard();

        $developer = new Developer($data);
        $result = $developer->save();

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {
        
        return Developer::find($id)->delete();
    }
    
    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {

        $categories = Developer::select(['id', 'name']);

        return $categories->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
