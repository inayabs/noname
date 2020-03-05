<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Course Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('user/list', 'Users\UserController@user_list')->name('user.list');
Route::get('user/search', 'Users\UserController@user_search')->name('user.search');
Route::delete('user/{id}', 'Users\UserController@destroy')->name('user.delete');
Route::post('user', 'Users\UserController@store')->name('user.store');
Route::put('user', 'Users\UserController@store')->name('user.update');