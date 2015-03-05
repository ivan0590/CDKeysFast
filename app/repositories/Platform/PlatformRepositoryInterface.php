<?php

namespace Repositories\Platform;

/**
 *
 * @author Ivan
 */
interface PlatformRepositoryInterface {

    public function find($id);

    public function create($data);

    public function update($id, $data);

    public function erase($id);

    public function getByName($name);
    
    public function exists($id);

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15);
}
