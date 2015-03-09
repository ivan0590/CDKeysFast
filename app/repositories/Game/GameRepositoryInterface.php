<?php

namespace Repositories\Game;

/**
 *
 * @author Ivan
 */
interface GameRepositoryInterface {

    public function find($id);
    
    public function create($data);

    public function erase($id);

    public function update($id, $data);

    public function getByName($name);

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1);
}
