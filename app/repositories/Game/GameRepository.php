<?php

namespace Repositories\Game;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Game as Game;

/**
 * Description of GameRepository
 *
 * @author Ivan
 */
class GameRepository extends BaseRepository implements GameRepositoryInterface {

    public function __construct(Game $model) {
        $this->model = $model;
    }

    public function getByName($name) {
        return Game::where('name', '=', $name)->first();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1) {

        $games = Game::
                leftJoin('categories', 'games.category_id', '=', 'categories.id')
                ->leftJoin('agerates', 'games.agerate_id', '=', 'agerates.id')
                ->select(['games.id as id',
            'games.name as game_name',
            'categories.name as category_name',
            'agerates.name as agerate_name']);

        \Paginator::setCurrentPage(($games->count() / $pagination) < $page ? ceil($games->count() / $pagination) : $page);

        return $games->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
