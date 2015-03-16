<?php

namespace Repositories\Publisher;

/**
 *
 * @author Ivan
 */
interface PublisherRepositoryInterface {
    
    public function getByName($name);
    
    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1);
}
