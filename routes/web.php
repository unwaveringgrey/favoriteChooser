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

//Auth::routes();

Route::get('/', 'HomeController@home')->name('home');

Route::get('/chooser', 'ChooserController@play')->name('favorite_select');

Route::post('/chooser', 'ChooserController@submit')->name('favorite_submit');

Route::get('/add_endpoint', 'EndpointController@add')->name('endpoint_add');

Route::post('/add_endpoint', 'EndpointController@submit')->name('endpoint_submit');

//mainly useful for debugging
Route::get('/random', 'HomeController@random')->name('random_endpoint');
