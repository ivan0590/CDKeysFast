<?php

class MassiveUploadController extends \BaseController {

    /**
     * 
     *
     * @return Response
     */
    public function create() {

        //Miga de pan
        Breadcrumb::addBreadcrumb('Carga masiva de productos');

        return View::make('admin.pages.massive_upload')
                        ->with('breadcrumbs', Breadcrumb::generate());
    }

    /**
     * 
     *
     * @return Response
     */
    public function store() {
        
    }

}
