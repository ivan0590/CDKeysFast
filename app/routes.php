<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the Closure to execute when that URI is requested.
  |
 */

//Raíz
Route::get('/', [
    'as' => 'index',
    'uses' => 'StoreFrontController@getIndex',
    'before' => 'sort'
]);

//Login y logout
Route::resource('session', 'SessionController', ['only' => ['store', 'destroy']]);

//Búsquedas
Route::group(['prefix' => 'search', 'before' => 'sort'], function () {

    //Búsqueda simple
    Route::get('/simple', ['as' => 'search.simple', 'uses' => 'SearchController@simple']);

    //Búsqueda avanzada
    Route::get('/advanced', ['as' => 'search.advanced', 'uses' => 'SearchController@advanced']);
});

//Usuarios
Route::resource('user', 'UserController', ['except' => ['index', 'update']]);

//Plataforma
Route::resource('platform', 'PlatformController', ['except' => ['index', 'create', 'edit']]);

//Categoría
Route::resource('platform.category', 'CategoryController', ['except' => ['index', 'create', 'edit']]);

//Producto
Route::resource('platform.category.product', 'ProductController', ['except' => ['index', 'create', 'edit']]);

//Enviar emails
Route::group(['prefix' => 'send'], function () {
   
    //Email de confirmación
    Route::get('/verify/{email}', [
        'as' => 'send_verify',
        'uses' => 'UserController@sendConfirmationCode'
    ]);
});

//Confirmar email de usuario
Route::get('user/create/confirm/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'UserController@confirm'
]);


//Mostrar mensaje
Route::get('/info', [
    'as' => 'info',
    'uses' => 'StoreFrontController@getInfo'
]);
