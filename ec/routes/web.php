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

Route::get('/products', 'ProductsController@index');
Route::post('/products/store', 'ProductsController@store');
Route::patch('/products/change_stock/{product}', 'ProductsController@change_stock');
Route::patch('/products/change_status/{product}', 'ProductsController@change_status');
Route::delete('/products/{product}', 'ProductsController@destroy');
Route::get('/top', 'ProductsController@top');

Route::get('/users', 'UsersController@index');
Route::patch('/users/change_status/{user}', 'UsersController@change_status');

Route::get('/signup', 'HomeController@signup');
Route::post('/signup/create', 'HomeController@create');
Route::get('/signin', 'HomeController@signin');
Route::post('/signin/login', 'HomeController@login');
Route::get('/signout', 'HomeController@signout');
