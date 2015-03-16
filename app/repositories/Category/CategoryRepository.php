<?php

namespace Repositories\Category;

use KyleNoland\LaravelBaseRepository\BaseRepository as BaseRepository;
use \Category as Category;

/**
 * Description of CategoryRepository
 *
 * @author Ivan
 */
class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface {

    public function __construct(Category $model) {
        $this->model = $model;
    }
    
    public function getByName($name) {
        return Category::where('name', '=', $name)->first();
    }

    public function getByPlatformWhereHasProducts($platformId) {

        return Category::whereHas('games', function ($gamesQuery) use($platformId) {
                            $gamesQuery->whereHas('products', function ($productsQuery) use ($platformId) {
                                $productsQuery->where('platform_id', '=', $platformId)->orderBy('name', 'asc');
                            });
                        })->selectRaw("id, name, description, (select count(*) from games where games.category_id = categories.id and (select count(*) from products where products.game_id = games.id and platform_id = $platformId order by name asc) >= 1) as products_count")
                        ->get();
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
