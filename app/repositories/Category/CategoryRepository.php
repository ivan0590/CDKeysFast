<?php

namespace Repositories\Category;

use \Category as Category;

/**
 * Description of CategoryRepository
 *
 * @author Ivan
 */
class CategoryRepository implements CategoryRepositoryInterface {

    public function find($id) {
        return Category::find($id);
    }

    public function create($data) {

        \Eloquent::unguard();

        $category = new Category($data);
        $result = $category->save();

        \Eloquent::reguard();

        return $result;
    }

    public function update($id, $data) {

        \Eloquent::unguard();

        $result = Category::find($id)->update($data);

        \Eloquent::reguard();

        return $result;
    }

    public function erase($id) {

        return Category::find($id)->delete();
    }

    public function getByName($name) {
        return Category::where('name', '=', $name)->first();
    }
    
    public function getByPlatformWhereHasProducts($platformId) {

        $p =  Category::whereHas('games', function ($gamesQuery) use($platformId) {
                    $gamesQuery->whereHas('products', function ($productsQuery) use ($platformId) {
                        $productsQuery->where('platform_id', '=', $platformId)->orderBy('name', 'asc');
                    });
                })->selectRaw("id, name, description, (select count(*) from games where games.category_id = categories.id and (select count(*) from products where products.game_id = games.id and platform_id = $platformId order by name asc) >= 1) as products_count")
                        ->get();
        
//        dd($p->toArray());
        
        return $p;
    }

    public function exists($id, $platformId = null) {
        $category = Category::where('id', '=', $id);

        if ($platformId) {
            $category = $category->whereHas('games', function ($gamesQuery) use($platformId) {
                $gamesQuery->whereHas('products', function ($productsQuery) use ($platformId) {
                    $productsQuery->where('platform_id', '=', $platformId)->orderBy('name', 'asc');
                });
            });
        }

        return !$category->get()->isEmpty();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15, $page = 1) {

        $categories = Category::select(['id', 'name']);

        \Paginator::setCurrentPage(($categories->count() / $pagination) < $page ? ceil($categories->count() / $pagination) : $page);
        
        return $categories->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
