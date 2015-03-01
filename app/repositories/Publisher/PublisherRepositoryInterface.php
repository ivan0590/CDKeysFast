<?php

namespace Repositories\Publisher;

/**
 *
 * @author Ivan
 */
interface PublisherRepositoryInterface {
    
    public function create($data);
    
    public function erase($id);
    
    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15);
}
