<?php

namespace Repositories\Category;

/**
 *
 * @author Ivan
 */
interface CategoryRepositoryInterface {

    public function find($id);
    
    public function getByPlatformWhereHasProducts($platformId);
    
}
