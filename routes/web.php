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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
});

Route::get('/chooser', 'ChooserController@play')->name('favorite_select');

Route::post('/chooser', 'ChooserController@submit')->name('favorite_submit');


//Route::get('/endpoint/{id}', 'EndpointsAPI\EndpointController@getEndpointJSON')->name('endpoint_get');

//Route::put('/endpoint', 'EndpointsAPI\EndpointController@putEndpoint')->name('endpoint_put');

//Route::delete('/endpoint/{id}', 'EndpointsAPI\EndpointController@deleteEndpoint')->name('endpoint_delete');
