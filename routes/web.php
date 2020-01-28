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

Route::get('/', 'ApiController@todoView');
Route::get('api/todoList', 'ApiController@getList');
Route::get('api/todoGenerate', 'ApiController@todoGenerate');