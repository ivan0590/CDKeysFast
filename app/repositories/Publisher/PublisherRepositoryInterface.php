<?php

namespace Repositories\Publisher;

/**
 *
 * @author Ivan
 */
interface PublisherRepositoryInterface {
    
    public function find($id);

    public function create($data);
    
    public function update($id, $data);

    public function erase($id);
    
    public function getByName($name);
    
    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15);
}
