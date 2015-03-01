<?php

namespace Repositories\Category;

use \Category as Category;

/**
 * Description of CategoryRepository
 *
 * @author Ivan
 */
class CategoryRepository implements CategoryRepositoryInterface {

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

    public function find($id) {
        return Category::find($id);
    }

    public function getByPlatformWhereHasProducts($platformId) {

        return Category::whereHas('games', function ($gamesQuery) use($platformId) {
                    $gamesQuery->whereHas('products', function ($productsQuery) use ($platformId) {
                        $productsQuery->where('platform_id', '=', $platformId)->orderBy('name', 'asc');
                    });
                })->get();
    }

}
