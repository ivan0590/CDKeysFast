<?php

namespace Repositories\Product;

/**
 * 
 *
 * @author Ivan
 */
interface ProductRepositoryInterface {
    
    public function find($id);
    
    public function create($data);
    
    public function update($id, $data);
    
    public function erase($id);
    
    public function addDeveloper($id, $developer);
    
    public function addAudio($id, $language);
    
    public function addText($id, $language);
    
    public function getByGameAndPlatform($gameId, $platformId);
    
    public function exists($id, $platformId = null, $categoryId = null);
            
    public function paginateForIndexTable($sort = 'name',
                             $sortDir = 'asc',
                             $pagination = 15);
    
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
