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

//Usuario
Route::resource('user', 'UserController', ['except' => ['index', 'show', 'update', 'destroy']]);

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

Route::group(['prefix' => 'update'], function () {

    //Actualizar email
    Route::post('/{id}/email', [
        'as' => 'update_email',
        'uses' => 'UserController@updateEmail'
    ]);

    //Actualizar contraseña
    Route::post('/{id}/password', [
        'as' => 'update_password',
        'uses' => 'UserController@updatePassword'
    ]);

    //Actualizar datos personales
    Route::post('/{id}/personal', [
        'as' => 'update_personal',
        'uses' => 'UserController@updatePersonal'
    ]);
});

//Darse de baja
Route::post('unsuscribe/{id}', [
    'as' => 'unsuscribe',
    'uses' => 'UserController@unsuscribe'
]);

Route::group(['prefix' => 'confirm'], function () {

    //Confirmar usuario
    Route::get('/{id}/user/{confirmationCode}', [
        'as' => 'confirm_user',
        'uses' => 'UserController@confirm'
    ]);

    //Confirmar cambio de email
    Route::get('/{id}/email/{confirmationCode}', [
        'as' => 'confirm_email',
        'uses' => 'UserController@confirmEmail'
    ]);

    //Confirmar cambio de contraseña
    Route::get('/{id}/password/{confirmationCode}', [
        'as' => 'confirm_password',
        'uses' => 'UserController@confirmPassword'
    ]);

    //Confirmar baja
    Route::get('/{id}/unsuscribe/{confirmationCode}', [
        'as' => 'confirm_unsuscribe',
        'uses' => 'UserController@confirmUnsuscribe'
    ]);
});

//Mostrar mensaje
Route::get('/info', [
    'as' => 'info',
    'uses' => 'StoreFrontController@getInfo'
]);
