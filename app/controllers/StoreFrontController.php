<?php

class StoreFrontController extends \BaseController {

    /**
     * Página principal
     *
     * @return index
     */
    public function getIndex() {

        //Productos destacados
        $highlightedProducts = Product::join('games', 'products.game_id', '=', 'games.id')
                ->where('highlighted', '=', true);

        //Productos destacados y ofertas con descuento
        if (Auth::check()) {
            $highlightedProducts = $highlightedProducts->whereNotNull('discount');
            $offerProducts = Product::whereNotNull('discount')->get()->sortByDesc('discount')->take(5);

            //Productos destacados y ofertas sin descuento
        } else {
            $highlightedProducts = $highlightedProducts->whereNull('discount');
            $offerProducts = Product::whereNull('discount')->get()->sortBy('price')->take(5);
        }

        //Productos destacados, con o sin descuento, ordenados por nombre, precio o descuento
        $highlightedProducts = $highlightedProducts
                        ->orderBy(Input::get('sort', 'name'), Input::get('sort_dir', 'asc'))->paginate(15);

        //Página de inicio con los productos destacados paginados de 15 en 15 y ordenados
        return View::make('client.pages.index')
                        ->with('products', $highlightedProducts)
                        ->with('offerProducts', $offerProducts);
    }

    public function getInfo() {

        return View::make('client.pages.info')->with('message', Session::get('message'));
    }

}
