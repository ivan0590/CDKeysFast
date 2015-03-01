<?php

namespace Repositories\Category;

/**
 *
 * @author Ivan
 */
interface CategoryRepositoryInterface {

    public function create($data);
    
    public function erase($id);
    
    public function exists($id, $platformId = null);
    
    public function find($id);
    
    public function getByPlatformWhereHasProducts($platformId);
    
    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15);
}
