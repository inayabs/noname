<?php

/*
|--------------------------------------------------------------------------
| Email Templates Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Resource
Route::resource('email-templates', 'Email\EmailTemplatesController');
Route::get('letter-templates', 'Email\EmailTemplatesController@index')->name('letter-templates.index');
Route::get('email-templates/list/templates', 'Email\EmailTemplatesController@get_templates_list')->name('template.templates-list')->middleware('auth');
Route::put('email-templates/store-update/template', 'Email\EmailTemplatesController@template_store_update')->name('template.store_update');
Route::get('email-templates/delete/{id}', 'Email\EmailTemplatesController@destroy')->name('email-templates.destroy');