<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/endpoint', 'EndpointsAPI\EndpointController@getEndpointsJSON')->name('endpoints_get');

Route::get('/endpoint/{id}', 'EndpointsAPI\EndpointController@getEndpointJSON')->name('endpoint_get');

Route::put('/endpoint', 'EndpointsAPI\EndpointController@putEndpoint')->name('endpoint_put');

Route::delete('/endpoint/{id}', 'EndpointsAPI\EndpointController@deleteEndpoint')->name('endpoint_delete');
