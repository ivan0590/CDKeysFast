<?php

namespace Repositories\Agerate;

use \Agerate as Agerate;

/**
 * Description of AgerateRepository
 *
 * @author Ivan
 */
class AgerateRepository implements AgerateRepositoryInterface {

    public function find($id) {
        return Agerate::find($id);
    }

    public function create($data) {

        \Eloquent::unguard();

        $game = new Agerate($data);
        $result = $game->save();

        \Eloquent::reguard();

        return $result;
    }

    public function update($id, $data) {

        \Eloquent::unguard();

        $result = Agerate::find($id)->update($data);

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {
        return Agerate::find($id)->delete();
    }

    public function getByName($name) {
        return Agerate::where('name', '=', $name)->first();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {

        $games = Agerate::
                leftJoin('categories', 'games.category_id', '=', 'categories.id')
                ->leftJoin('agerates', 'games.agerate_id', '=', 'agerates.id')
                ->select(['games.id as id',
            'games.name as game_name',
            'categories.name as category_name',
            'agerates.name as agerate_name']);

        return $games->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
