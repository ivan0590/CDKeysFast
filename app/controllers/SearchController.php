<?php

class SearchController extends \BaseController {

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function show() {

        if (Input::has('name')) {
            Input::flash();
        } else {
            Session::reflash();
        }
        
        $products = Product::whereHas('game', function ($game) {
                    $game->where('name', 'like', '%' . Input::old('name') . '%');
                });

        return View::make('client.pages.search_results')
                        ->with('products', $products->paginate(15))
                        ->with('search', Input::old('name'));
    }

}
