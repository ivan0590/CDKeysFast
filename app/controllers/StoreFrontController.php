<?php

class StoreFrontController extends \BaseController {

    /**
     * Página principal
     *
     * @return index
     */
    public function getIndex($sort = null) {


        //Productos destacados
        $highlightedProducts = Product::join('games', 'products.game_id', '=', 'games.id')
                ->where('highlighted', '=', true);

        //Productos destacados con descuento para usuarios registrados
        if (Auth::check()) {
            $highlightedProducts = $highlightedProducts->whereNotNull('discount');
        
        //Productos destacados sin descuento para invitados
        } else {
            $highlightedProducts = $highlightedProducts->whereNull('discount');
        }

        //Ordenación de los productos
        switch ($sort) {
            //Precio ascendente
            case 'price-asc':
                $column = 'products.price';
                $direction = 'asc';
                break;
            
            //Precio descendente
            case 'price-desc':
                $column = 'products.price';
                $direction = 'desc';
                break;

            //Nombre ascendente
            case 'name-desc':
                $column = 'games.name';
                $direction = 'desc';
                break;
            
            //Nombre descendente
            default:
                $column = 'games.name';
                $direction = 'asc';
                break;
        }
        
        //Los cinco productos destacados más baratos
        $offerProducts = $highlightedProducts->orderBy('products.price', 'asc')->get()->take(5);
        
        //Página de inicio con los productos destacados paginados de 15 en 15 y ordenados
        return View::make('client.pages.index')
                ->with('highlightedProducts',$highlightedProducts->orderBy($column, $direction)->paginate(15))
                    ->with('offerProducts', $offerProducts);
    }

    public function getInfo() {

        return View::make('client.pages.info')->with('message', Session::get('message'));
    }

}
