<?php

/*
|--------------------------------------------------------------------------
| Timelog Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('timelog', 'Timelog\TimelogController');
// Timelog Process
Route::get('/timelog/today/list/', 'Timelog\TimelogController@today_timelog')->name('timelog.today-list');
Route::post('/timelog/time-in/store', 'Timelog\TimelogController@time_in')->name('timelog.time-in');
Route::put('/timelog/time-out/update/{id}', 'Timelog\TimelogController@time_out')->name('timelog.time-out');
// Break Process
Route::post('/timelog/start-break/store', 'Timelog\TimelogController@start_break')->name('timelog.start-break');
Route::put('/timelog/end-break/update/{id}', 'Timelog\TimelogController@end_break')->name('timelog.end-break');

Route::get('/timelog/summary/user', 'Timelog\TimelogController@summary')->name('timelog.summary');
Route::get('/timelog/summary/list', 'Timelog\TimelogController@summary_list')->name('timelog.summary.list');