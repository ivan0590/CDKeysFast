<?php

namespace Repositories\Game;

/**
 *
 * @author Ivan
 */
interface GameRepositoryInterface {
    
    public function create($data);
    
    public function erase($id);
    
    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15);

}
