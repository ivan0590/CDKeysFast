<?php

use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;

class SearchController extends \BaseController {

    public function __construct(ProductRepositoryInterface $product) {
        $this->product = $product;
    }

    /**
     * 
     *
     * @return Response
     */
    public function simple() {

        Input::flash();

        $foundProducts = $this->product
                ->paginateSimpleSearch(Input::get('ss-name'), Input::get('sort', 'name'), Input::get('sort_dir', 'asc'));

        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb("Búsqueda");

        return View::make('client.pages.simple_search')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('products', $foundProducts);
    }

    /**
     * 
     *
     * @return Response
     */
    public function advanced() {

        Input::flash();

        $sort = Input::get('sort') === 'name' ? 'games.' . Input::get('sort') : Input::get('sort', 'games.name');

        //Se busca por los valores del formulario, se ordena y se pagina
        $foundProducts = $this->product
                ->paginateAdvancedSearch(Input::all(), $sort, Input::get('sort_dir', 'asc'));
        
        //Miga de pan
        Breadcrumb::addBreadcrumb('Inicio', URL::route('index'));
        Breadcrumb::addBreadcrumb('Búsqueda avanzada');

        return View::make('client.pages.advanced_search')
                        ->with('breadcrumbs', Breadcrumb::generate())
                        ->with('products', $foundProducts)
                        ->withInput(Input::all());
    }

}
