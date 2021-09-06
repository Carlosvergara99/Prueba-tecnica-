<?php


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

Route::group(['prefix' => 'brand'], function () {
    Route::get('get', 'BrandController@get');
    Route::post('create', 'BrandController@store');
    Route::post('update', 'BrandController@update');
    Route::post('delete', 'BrandController@destroy');
});


Route::group(['prefix' => 'product'], function () {
    Route::get('get', 'ProductController@get');
    Route::post('create', 'ProductController@store');
    Route::post('update', 'ProductController@update');
    Route::post('delete', 'ProductController@destory');
});