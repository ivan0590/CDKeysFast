<?php

namespace Repositories\Developer;

/**
 *
 * @author Ivan
 */
interface DeveloperRepositoryInterface {
    
    public function find($id);
    
    public function create($data);
    
    public function update($id, $data);
    
    public function erase($id);
    
    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15);

}
