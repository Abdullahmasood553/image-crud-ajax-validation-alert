<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'PostController@index');

// Save Post
Route::post('save_post', 'PostController@save_post');


Route::get('get_posts', 'PostController@get_posts');
Route::get('edit/get_posts', 'PostController@get_posts');



Route::get('edit/{id}', 'PostController@edit');



Route::post('edit/update_post/{id}', 'PostController@update');


Route::get('del_post/{id}', 'PostController@delete_post');