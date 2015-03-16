<?php

namespace Repositories\Game;

/**
 *
 * @author Ivan
 */
interface GameRepositoryInterface {

    public function getByName($name);

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1);
}
