<?php

namespace Repositories\Platform;

use \Platform as Platform;

/**
 * Description of PlatformRepository
 *
 * @author Ivan
 */
class PlatformRepository implements PlatformRepositoryInterface {

    public function find($id) {
        return Platform::find($id);
    }

    public function create($data) {

        \Eloquent::unguard();

        $platform = new Platform($data);
        $result = $platform->save();

        \Eloquent::reguard();

        return $result;
    }

    public function update($id, $data) {

        \Eloquent::unguard();

        $result = Platform::find($id)->update($data);

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {
        return Platform::find($id)->delete();
    }

    public function exists($id) {
        return !Platform::where('id', '=', $id)->get()->isEmpty();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {

        $platforms = Platform::select(['id', 'name']);

        return $platforms->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
