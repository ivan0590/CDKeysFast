<?php

use Repositories\Platform\PlatformRepositoryInterface as PlatformRepositoryInterface;
use Repositories\Category\CategoryRepositoryInterface as CategoryRepositoryInterface;
use Repositories\Product\ProductRepositoryInterface   as ProductRepositoryInterface;

class ProductController extends \BaseController {

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
     * @param  int  $platformId
     * @return Response
     */
    public function show($platformId, $categoryId, $productId) {

        //Producto no existente para ese id, plataforma y categoría
        if (!$this->product->exists($productId, $platformId, $categoryId)) {
            return Redirect::route('index');
        }

        //Se añaden los ids de la plataforma, la categoría y el producto  al input
        Input::replace(array_merge(['platform_id' => $platformId, 'category_id' => $categoryId, 'product_id' => $productId],
                                   Input::all()));
        
        //Producto
        $product = $this->product->find($productId);
        
        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb($product->platform->name, URL::route('platform.show', ['platform_id' => $productId]));
        Breadcrumb::addBreadcrumb($product->game->category->name, URL::route('platform.category.show', ['platform_id' => $platformId, 'category_id' => $categoryId]));
        Breadcrumb::addBreadcrumb($product->game->name);

        return View::make('client.pages.product')
                ->with('product', $product)
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
