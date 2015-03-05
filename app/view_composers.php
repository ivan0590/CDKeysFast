<?php
/*
  |--------------------------------------------------------------------------
  | Composers
  |--------------------------------------------------------------------------
 */

//Para cargar todas las plataformas
View::composer('client.includes.nav', function($view) {
    $view->with('platforms', Platform::all());
});

//Para generar las opciones de ordenación de productos
View::composer(['client.includes.products_list'], function($view) {

    //Opciones que siempre están
    $permanent = [
        ['label' => 'Juego A-Z', 'parameters' => ['sort' => 'name', 'sort_dir' => 'asc', 'page' => '1']],
        ['label' => 'Juego Z-A', 'parameters' => ['sort' => 'name', 'sort_dir' => 'desc', 'page' => '1']]
    ];

    //Ordenar por descuento en caso estar logueado
    if (Auth::check()) {
        $dinamic = [
            ['label' => 'Menores descuentos', 'parameters' => ['sort' => 'discount', 'sort_dir' => 'asc', 'page' => '1']],
            ['label' => 'Mayores descuentos', 'parameters' => ['sort' => 'discount', 'sort_dir' => 'desc', 'page' => '1']]
        ];
        
    //Ordenar por precio en caso contrario
    } else {
        $dinamic = [
            ['label' => 'Precio ascendente', 'parameters' => ['sort' => 'price', 'sort_dir' => 'asc', 'page' => '1']],
            ['label' => 'Precio descendente', 'parameters' => ['sort' => 'price', 'sort_dir' => 'desc', 'page' => '1']]
        ];
    }
    
    $view->with('orderBy', array_merge($permanent, $dinamic));
});

//Para cargar los valores de las listas cerradas en el formulario de búsqueda
View::composer(['client.pages.advanced_search',
                'admin.pages.create',
                'admin.pages.edit'], function($view) {

    $models = [
        'platforms' => 'Platform',
        'games' => 'Game',
        'categories' => 'Category',
        'developers' => 'Developer',
        'publishers' => 'Publisher',
        'agerates' => 'Agerate'
    ];
    
    foreach ($models as $key => $model) {
        $data[$key] = array_combine($model::orderBy('id', 'asc')->lists('id'),
                                    $model::orderBy('id', 'asc')->lists('name'));
        
        if($view->getName() === 'client.pages.advanced_search'){
            $data[$key] = [null => 'Cualquiera'] + $data[$key];
        }
    }

    $view->with($data);
});

//Etiquetas de las pestañas de edición y creación
View::composer(['admin.pages.index',
                'admin.pages.create'], function($view) {
        
    $tabs = [
        'product'   => 'Productos',
        'game'      => 'Juegos',
        'platform'  => 'Platformas',
        'category'  => 'Categorías',
        'developer' => 'Desarrolladoras',
        'publisher' => 'Distribuidoras'
    ];
    
    $view->with('tabs', $tabs);
});