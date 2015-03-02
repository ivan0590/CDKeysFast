<?php

namespace Repositories\Game;

use \Game as Game;

/**
 * Description of GameRepository
 *
 * @author Ivan
 */
class GameRepository implements GameRepositoryInterface {

    public function find($id) {
        return Game::find($id);
    }

    public function create($data) {

        \Eloquent::unguard();

        $game = new Game($data);
        $result = $game->save();

        \Eloquent::reguard();

        return $result;
    }

    public function update($id, $data) {

        \Eloquent::unguard();

        $result = Game::find($id)->update($data);

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {
        return Game::find($id)->delete();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {

        $games = Game::
                leftJoin('categories', 'games.category_id', '=', 'categories.id')
                ->leftJoin('agerates', 'games.agerate_id', '=', 'agerates.id')
                ->select(['games.id as id',
            'games.name as game_name',
            'categories.name as category_name',
            'agerates.name as agerate_name']);

        return $games->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
