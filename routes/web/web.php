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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/dashboard', 'HomeController@index')->name('home');
Route::get('/', 'HomeController@index')->name('home');
Route::get('/dynamic-form', 'HomeController@dynamic_form')->name('dynamic-form');

