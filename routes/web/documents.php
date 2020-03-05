<?php

/*
|--------------------------------------------------------------------------
| Documents Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('documents', 'Documents\DocumentsController@index')->name('documents.index');
Route::post('documents/upload', 'Documents\DocumentsController@documents_upload');
Route::get('documents/fetch', 'Documents\DocumentsController@documents_fetch');
Route::get('documents/delete/{id}', 'Documents\DocumentsController@documents_delete');
Route::get('documents/preview/{id}', 'Documents\DocumentsController@documents_preview');
Route::get('documents/update/{uid}', 'Documents\DocumentsController@documents_update');

Route::post('documents/related/upload', 'Documents\DocumentsController@documents_related_upload');
Route::get('documents/related/fetch/{uid}', 'Documents\DocumentsController@documents_related_fetch');
Route::put('documents/note/update/{id}', 'Documents\DocumentsController@documents_note_update');
// Route::resource('documents', 'Documents\DocumentsController')->middleware('auth');

