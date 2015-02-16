<?php

namespace Repositories\Category;

/**
 *
 * @author Ivan
 */
interface CategoryRepositoryInterface {

    public function getByPlatformWhereHasProducts($platformId, $chunk);
    
}
