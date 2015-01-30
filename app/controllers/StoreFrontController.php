<?php

class StoreFrontController extends \BaseController {

    /**
     * Página principal
     *
     * @return index
     */
    public function getIndex() {
                
        return View::make('client.pages.index');
    }

}
