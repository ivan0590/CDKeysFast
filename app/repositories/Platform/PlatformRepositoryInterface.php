<?php

namespace Repositories\Platform;

/**
 *
 * @author Ivan
 */
interface PlatformRepositoryInterface {
    
    public function create($data);

    public function erase($id);
    
    public function exists($id);
    
    public function find($id);
    
    public function paginateForEditionTable($sort = 'name',
                             $sortDir = 'asc',
                             $pagination = 15);
    
}
