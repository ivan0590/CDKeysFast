<?php

namespace Repositories\Category;

/**
 *
 * @author Ivan
 */
interface CategoryRepositoryInterface {

    public function exists($id, $platformId = null);
    
    public function find($id);
    
    public function getByPlatformWhereHasProducts($platformId);
    
}
