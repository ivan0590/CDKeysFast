<?php

namespace Repositories\Game;

use \Game as Game;

/**
 * Description of GameRepository
 *
 * @author Ivan
 */
class GameRepository implements GameRepositoryInterface {

    public function create($data) {
                
        \Eloquent::unguard();
        
        $game = new Game($data);
        $result = $game->save();
        
        \Eloquent::reguard();
        
        return $result;
    }
    
    public function erase($id) {
        return Game::find($id)->delete();
    }
    
    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {

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
