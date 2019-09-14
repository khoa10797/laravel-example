<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\HomeController;

Route::get('/', function () {
    return view('home.index');
});

Auth::routes();

Route::get('/menu/search/{search}', 'MenuController@search');
Route::get('/menu/category/{category}', 'MenuController@findByCategory');

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
});

Route::resources([
    'home' => 'HomeController',
    'menu' => 'MenuController',
    'order' => 'OrderController',
    'admin/product' => 'Admin\ProductController'
]);
