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

        //Se añade el id al input
        Input::replace(array_merge(['platform_id' => $id], Input::all()));
        
        $platform = $this->platform->find($id);

        //Id no existente
        if (!$platform) {
            return Redirect::route('index');
        }

        $categories = $this->category->getByPlatformWhereHasProducts($platform->id, 6);
        
        $products = $this->product->paginateHighlighted($platform->id, Auth::check(), Input::get('sort', 'name'), Input::get('sort_dir', 'asc'));
        
        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb($platform->name);

        return View::make('client.pages.platform')
                        ->with('platformName', $platform->name)
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
