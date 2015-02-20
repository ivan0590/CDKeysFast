<?php

use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;

class CategoryController extends \BaseController {

    public function __construct(PlatformRepositoryInterface $platform,
                                CategoryRepositoryInterface $category,
                                ProductRepositoryInterface $product) {
        $this->platform = $platform;
        $this->category = $category;
        $this->product = $product;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $platformId
     * @return Response
     */
    public function show($platformId, $categoryId) {

        //Categoría no existente para ese id y plataforma
        if (!$this->category->exists($categoryId, $platformId)) {
            return Redirect::route('index');
        }
       
        //Se añade el id de la plataforma y de la categoría al input
        Input::replace(array_merge(['platform_id' => $platformId, 'category_id' => $categoryId],
                                   Input::all()));
        
        
        //Plataforma
        $platform = $this->platform->find($platformId);
        
        //Categoría
        $category = $this->category->find($categoryId);

        //Productos para esa plataforma y categoría
        $products = $this->product->paginateByPlatformAndCategory($platformId,
                                                                  $categoryId,
                                                                  Input::get('sort', 'name'), 
                                                                  Input::get('sort_dir', 'asc'));
        
        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb($platform->name, URL::route('platform.show', ['platform_id' => $platformId]));
        Breadcrumb::addBreadcrumb($category->name);

        return View::make('client.pages.category')
                ->with('platform', $platform)
                ->with('category', $category)
                ->with('products', $products)
                ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
