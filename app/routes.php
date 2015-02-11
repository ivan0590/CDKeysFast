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


Route::get('/{sort?}', [
    'as' => 'index',
    'uses' => 'StoreFrontController@getIndex'
]);

Route::resource('session', 'SessionController', ['only' => ['store', 'destroy']]);

Route::resource('user', 'UserController', ['except' => ['index', 'update']]);

Route::get('user/create/confirm/{confirmationCode}', [
    'as' => 'confirmation_path',
    'uses' => 'UserController@confirm'
]);

Route::get('/info', [
    'as' => 'info',
    'uses' => 'StoreFrontController@getInfo'
]);
