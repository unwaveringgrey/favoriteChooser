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

Route::get('/', function () {
    return redirect("/chooser");
});

Route::get('/chooser', 'ChooserController@play')->name('favorite_select');

Route::post('/chooser', 'ChooserController@submit')->name('favorite_submit');

//Route::post('/chooser', function (\Illuminate\Http\Request $request) {
//    echo "HERE"; var_dump($request->all());exit();
//})->name('favorite_submit');

//mainly useful for debugging
Route::get('/random', 'ChooserController@random')->name('random_endpoint');
