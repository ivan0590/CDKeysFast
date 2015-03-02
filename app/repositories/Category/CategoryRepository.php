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

    public function getByPlatformWhereHasProducts($platformId) {

        return Category::whereHas('games', function ($gamesQuery) use($platformId) {
                    $gamesQuery->whereHas('products', function ($productsQuery) use ($platformId) {
                        $productsQuery->where('platform_id', '=', $platformId)->orderBy('name', 'asc');
                    });
                })->get();
    }

    public function paginateForIndexTable($sort = 'name', $sortDir = 'asc', $pagination = 15) {

        $categories = Category::select(['id', 'name']);

        return $categories->orderBy($sort, $sortDir)->paginate($pagination);
    }

}
