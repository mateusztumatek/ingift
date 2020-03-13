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

Route::get('/', 'HomeController@index');


Route::group(['prefix' => 'admin'], function () {
    Route::get('/product_designer', 'Voyager\ProductController@settings');
    Route::post('/products/copy', 'Voyager\ProductController@copy');
    Voyager::routes();
});
Route::post('upload/{path}', 'UploadController@upload');
Route::get('/produkt/{url}', 'ProductController@show');
Route::get('/generate_preview', 'HomeController@previewIframe');
Route::get('/categories', 'HomeController@categories');


Route::group(['prefix' => 'bread'], function (){
    Route::post('{model}', 'BreadController@store');
    Route::delete('{model}/{id}', 'BreadController@destroy');

    Route::put('{model}/{id}', 'BreadController@update');
    Route::get('{model}/{id}', 'BreadController@show');
    Route::get('{model}', 'BreadController@index');
});
