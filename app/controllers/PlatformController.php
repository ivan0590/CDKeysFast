<?php

use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface   as ProductRepositoryInterface;

class PlatformController extends \BaseController {

    public function __construct(PlatformRepositoryInterface $platform,
                                CategoryRepositoryInterface $category,
                                ProductRepositoryInterface  $product) {
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
     * @param  int  $id
     * @return Response
     */
    public function show($id) {

        //Plataforma no existente para ese id
        if (!$this->platform->exists($id)) {
            return Redirect::route('index');
        }

        //Se añade el id de la plataforma al input
        Input::replace(array_merge(['platform_id' => $id], Input::all()));
        
        //Plataforma
        $platform = $this->platform->find($id);
                
        //Categorías
        $categories = $this->category->getByPlatformWhereHasProducts($platform->id);
        
        //Productos destacados de la plataforma
        $products = $this->product->paginateHighlighted($platform->id, Auth::check(), Input::get('sort', 'name'), Input::get('sort_dir', 'asc'));
        
        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb($platform->name);

        return View::make('client.pages.platform')
                        ->with('platform', $platform)
                        ->with('categories', $categories)
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
