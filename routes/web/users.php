<?php

/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('user/list', 'Users\UserController@user_list')->name('user.list');
Route::get('user/search', 'Users\UserController@user_search')->name('user.search');
Route::delete('user/{id}', 'Users\UserController@destroy')->name('user.delete');
Route::post('user', 'Users\UserController@store')->name('user.store');
Route::put('user', 'Users\UserController@store')->name('user.update');

Route::get('user/show/{id}', 'Users\UserController@user_info')->name('user.show');
Route::post('user/show/update/{id}', 'Users\UserController@user_info_update')->name('user.show.update');
Route::post('/user/avatar', 'Users\UserController@avatar')->name('user.avatar');
// Resource
Route::resource('users', 'Users\UserController');