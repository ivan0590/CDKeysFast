<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route Filters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |
 */

App::before(function($request) {
    //
});


App::after(function($request, $response) {
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function() {
    if (Auth::guest()) {
        if (Request::ajax()) {
            return Response::make('Unauthorized', 401);
        }
        return Redirect::guest('login');
    }
});


Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});

/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */

Route::filter('csrf', function() {
    if (Session::token() !== Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

/*
  |--------------------------------------------------------------------------
  | My filters
  |--------------------------------------------------------------------------
 */

//Filtro de ordenación
Route::filter('sort', function() {

    //Reglas de validación para los parámetros de ordenación
    $validationRules = [
        'sort' => 'in:price,name,discount',
        'sort_dir' => 'in:asc,desc'
    ];

    //Validación
    $validator = Validator::make(Input::only('sort', 'sort_dir', 'page'), $validationRules);
Route::currentRouteName();
    //No se pasa la validación y se redirige a la misma página sin parámetros
    if ($validator->fails() || (Input::get('sort') === 'discount' && !Auth::check())) {
        return Redirect::route(Route::currentRouteName());
    }
});

//Filtro administrativo
Route::filter('admin', function() {

    if (!Auth::check() || Auth::user()->userable_type !== 'Admin') {
        return Redirect::route('index');
    }
});

//Filtro para acceder solo si se está logueado
Route::filter('login-needed', function() {

    if (!Auth::check()) {
        return Redirect::route('index');
    }
});

//Filtro para evitar determinadas rutas estando logueado
Route::filter('login-avoid', function() {

    if (Auth::check()) {
        return Redirect::route('index');
    }
});


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
                'admin.pages.create.product',
                'admin.pages.create.game'], function($view) {

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

//Para cargar los valores de las listas cerradas en el formulario de búsqueda
View::composer('admin.includes.tabs', function($view) {
    
});

//Etiquetas de las pestañas de edición y creación
View::composer(['admin.pages.edition',
                'admin.pages.create.*'], function($view) {
        
    $tabs = [
        'product'   => 'Productos',
        'game'      => 'Juegos',
        'platform'  => 'Platformas',
        'category'  => 'Categorías',
        'developer' => 'Desarrolladoras',
        'publisher' => 'Distribuidoras'
    ];
    
    $view->with(['tabs' => $tabs]);
});