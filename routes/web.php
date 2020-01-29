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

Route::get('/approval', 'HomeController@approval')->name('approval');


Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home');


Route::get('import', 'ImportController@getImport')->name('import')->middleware('auth')->middleware('approved');
Route::get('records', 'RecordsController@index')->name('records')->middleware('auth')->middleware('approved');
Route::get('/records/{id}', 'RecordController@index')->name('record')->middleware('auth')->middleware('approved');
Route::get('/records/pdf/{id}', 'RecordController@getPdfExport')->name('record')->middleware('auth')->middleware('approved');

Route::get('settings', 'SettingsController@index')->name('settings')->middleware('auth')->middleware('approved');
Route::get('settings/approve/{user_id}', 'SettingsController@approveUser')->name('settings.approve')->middleware('auth')->middleware('approved');


//Route::post('import_parse', 'ImportController@parseImport')->name('import_parse');
//Route::post('save_import', 'ImportController@saveImport')->name('save_import');