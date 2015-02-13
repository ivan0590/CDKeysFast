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
Route::resource('search', 'SearchController', ['only' => ['create', 'show']]);

//Usuarios
Route::resource('user', 'UserController', ['except' => ['index', 'update']]);

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
