<?php

use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;

class StoreFrontController extends \BaseController {

    public function __construct(ProductRepositoryInterface $product) {
        $this->product = $product;
    }

    /**
     * Página principal
     *
     * @return index
     */
    public function getIndex() {

        //Productos destacados
        $highlightedProducts = $this->product->paginateHighlighted(null, Auth::check(), Input::get('sort', 'name'), Input::get('sort_dir', 'asc'));

        //Los 5 productos con mayor descuento
        if (Auth::check()) {
            $offerProducts = $this->product->all(true, 'discount', 'desc')->take(5);
            //Los 5 productos más baratos
        } else {
            $offerProducts = $this->product->all(false, 'price', 'asc')->take(5);
        }

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio');

        //Página de inicio con los productos destacados paginados de 15 en 15 y ordenados
        return View::make('client.pages.index')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('products', $highlightedProducts)
                        ->with('offerProducts', $offerProducts);
    }

    /**
     * Página de mensaje
     *
     * @return index
     */
    public function getInfo() {

        if (!Session::has('message') && !Session::has('errors')) {
            return Redirect::route('index');
        }

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Aviso');

        return View::make('client.pages.info')
                        ->with('message', Session::get('message'))
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    public function getAbout() {

        //Miga de pan
        Breadcrumb::addBreadcrumb('Acerca de CDKeysFast');

        return View::make('client.pages.about')
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

}
