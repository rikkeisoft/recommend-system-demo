<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | This file is where you may define all of the routes that are handled
  | by your application. Just tell Laravel the URIs it should respond
  | to using a Closure or controller method. Build something great!
  |
 */

Auth::routes();
Route::get('/', 'BookController@index');
Route::get('show/{book}', 'BookController@show');
Route::get('category/{category}', 'BookController@getListBookByCategory');
Route::get('search', 'BookController@search');
Route::post('rate/{book}', 'BookController@rate');

Route::group(['prefix' => 'ajax', 'middleware' => 'ajax'], function () {
    Route::post('rate/{book}', 'BookController@rate');
});
