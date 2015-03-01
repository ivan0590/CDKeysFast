<?php

namespace Repositories\Platform;

use \Platform as Platform;

/**
 * Description of PlatformRepository
 *
 * @author Ivan
 */
class PlatformRepository implements PlatformRepositoryInterface {

    public function create($data) {
                
        \Eloquent::unguard();
        
        $platform = new Platform($data);
        $result = $platform->save();
        
        \Eloquent::reguard();
        
        return $result;
    }
    
    public function erase($id) {
        return Platform::find($id)->delete();
    }
    
    public function exists($id) {
        return !Platform::where('id', '=', $id)->get()->isEmpty();
    }

    public function find($id) {
        return Platform::find($id);
    }

    public function paginateForEditionTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {
        
        $platforms = Platform::select(['id', 'name']);
        
        return $platforms->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
