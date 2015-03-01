<?php

use Repositories\Product\ProductRepositoryInterface as ProductRepositoryInterface;

class AdministrationController extends \BaseController {

    public function __construct(ProductRepositoryInterface $product) {
        $this->product = $product;
    }
    
    public function getLogin() {
        
        return View::make('admin.pages.login');
    }
        
    public function getImport() {
        
        return View::make('admin.pages.import');
    }
}