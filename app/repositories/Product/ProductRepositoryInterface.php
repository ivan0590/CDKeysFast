<?php

namespace Repositories\Product;

/**
 * 
 *
 * @author Ivan
 */
interface ProductRepositoryInterface {
        
    public function addDeveloper($id, $developerId);
    
    public function addLanguage($id, $languageId, $type);
    
    public function removeDevelopers($id);
    
    public function removeLanguages($id);
    
    public function getByGameAndPlatform($gameId, $platformId);
    
    public function exists($id, $platformId = null, $categoryId = null);
            
    public function paginateForIndexTable($sort = 'name',
                             $sortDir = 'asc',
                             $pagination = 16,
                             $page = 1);
    
    public function paginateHighlighted($platformId = null,
                                        $discounted = null,
                                        $sort = 'name',
                                        $sortDir = 'asc',
                                        $pagination = 16);
    
    public function paginateSimpleSearch($name = null,
                                         $sort = 'name',
                                         $sortDir = 'asc',
                                         $pagination = 16);
    
    public function paginateAdvancedSearch($data = [], 
                                           $sort = 'name',
                                           $sortDir = 'asc',
                                           $pagination = 16);
    
    public function paginateByPlatformAndCategory($platformId,
                                                  $categoryId,
                                                  $sort = 'name',
                                                  $sortDir = 'asc',
                                                  $pagination = 16);
    
    public function all($discounted = null,
                        $sort = 'name',
                        $sortDir = 'asc');
    
}
