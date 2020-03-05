<?php

/*
|--------------------------------------------------------------------------
| Reports Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Resource
// Route::resource('reports', 'Report\ReportsController');


Route::resource('generate-list', 'Report\GenerateListController');

Route::get('generate-list/all/list', 'Report\GenerateListController@getGenerateList')->name('generate.list.all');

Route::get('generate-list/hospital/list', 'Report\GenerateListController@generateHospitalList')->name('generate.list.hospital');
Route::get('generate-list/staff/list', 'Report\GenerateListController@getStaffList')->name('generate.list.staff');
Route::get('generate-list/fetch/data/{deal_id}/{template_id}', 'Report\GenerateListController@fetchData')->name('generate.list.fetch.data');
// PDF Print
// Route::get('generate-list/letter/pdf', 'Report\GenerateListController@generatePdf')->name('generate.list.letter.pdf');

