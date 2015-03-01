<?php

namespace Repositories\Developer;

/**
 *
 * @author Ivan
 */
interface DeveloperRepositoryInterface {
  
    public function create($data);
    
    public function erase($id);
    
    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15);

}
