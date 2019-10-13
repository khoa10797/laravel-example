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
use App\Http\Controllers\OrderController;

Route::get('/', function () {
    return view('home.index');
});

Auth::routes();

Route::get('/menu/search/{search}', 'MenuController@search');
Route::get('/menu/category/{category}', 'MenuController@findByCategory');

Route::get('/admin', 'Admin\AdminController@index');
Route::get('/admin/order', 'OrderController@get');
Route::get('/admin/order/update/{id}/{status}', 'OrderController@updateStatus');
Route::get('/admin/order/{id}', 'OrderController@show');

Route::post('/order/invoiceDetail', 'OrderController@addItem');
Route::put('/order/invoiceDetail', 'OrderController@updateItem');
Route::get('/order/invoiceDetail/remove/{productId}', 'OrderController@removeItem');
Route::get('/order/export', 'ExcelController@exportAllInvoice');

Route::group(['namespace' => 'Auth'], function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login');
    Route::get('/logout', 'LoginController@logout');
    Route::get('login/google', 'LoginController@redirectToGoogle');
    Route::get('login/google/callback', 'LoginController@handleGoogleCallback');
});

Route::resources([
    'home' => 'HomeController',
    'menu' => 'MenuController',
    'order' => 'OrderController',
    'admin/product' => 'Admin\ProductController'
]);
