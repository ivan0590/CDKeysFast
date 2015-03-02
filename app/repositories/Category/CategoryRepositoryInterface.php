<?php

namespace Repositories\Category;

/**
 *
 * @author Ivan
 */
interface CategoryRepositoryInterface {
    
    public function find($id);

    public function create($data);
    
    public function update($id, $data);
    
    public function erase($id);
    
    public function exists($id, $platformId = null);
    
    public function getByPlatformWhereHasProducts($platformId);
    
    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15);
}
