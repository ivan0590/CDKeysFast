<?php

namespace Repositories\Developer;

/**
 *
 * @author Ivan
 */
interface DeveloperRepositoryInterface {

    public function getByName($name);

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1);
}
