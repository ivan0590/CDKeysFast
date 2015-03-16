<?php

namespace Repositories\Category;

/**
 *
 * @author Ivan
 */
interface CategoryRepositoryInterface {
    
    public function exists($id, $platformId = null);
    
    public function getByName($name);
    
    public function getByPlatformWhereHasProducts($platformId);
    
    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1);
}
