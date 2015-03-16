<?php

namespace Repositories\Platform;

/**
 *
 * @author Ivan
 */
interface PlatformRepositoryInterface {

    public function getByName($name);
    
    public function exists($id);

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1);
}
