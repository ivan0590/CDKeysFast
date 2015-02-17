<?php

namespace Repositories\Product;

/**
 * 
 *
 * @author Ivan
 */
interface ProductRepositoryInterface {
    
    public function paginateHighlighted($platformId = null,
                                        $discounted = null,
                                        $sort = 'name',
                                        $sortDir = 'asc',
                                        $pagination = 15);
    
    public function paginateSimpleSearch($name = null,
                                         $sort = 'name',
                                         $sortDir = 'asc',
                                         $pagination = 15);
    
    public function paginateAdvancedSearch($data = [], 
                                           $sort = 'name',
                                           $sortDir = 'asc',
                                           $pagination = 15);
    
    public function paginateByPlatformAndCategory($platformId,
                                                  $categoryId,
                                                  $sort = 'name',
                                                  $sortDir = 'asc',
                                                  $pagination = 15);
    
    public function all($discounted = null,
                        $sort = 'name',
                        $sortDir = 'asc');
    
}
