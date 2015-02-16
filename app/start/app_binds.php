<?php

/*
|--------------------------------------------------------------------------
| Repository binds
|--------------------------------------------------------------------------
|
| 
| 
| 
|
*/

App::bind('Repositories\\User\\UserRepositoryInterface', 'Repositories\\User\\UserRepository');
App::bind('Repositories\\Product\\ProductRepositoryInterface', 'Repositories\\Product\\ProductRepository');
App::bind('Repositories\\Platform\\PlatformRepositoryInterface', 'Repositories\\Platform\\PlatformRepository');
App::bind('Repositories\\Category\\CategoryRepositoryInterface', 'Repositories\\Category\\CategoryRepository');