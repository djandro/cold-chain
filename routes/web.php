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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('import', 'ImportController@getImport')->name('import');
//Route::post('import_parse', 'ImportController@parseImport')->name('import_parse');
//Route::post('save_import', 'ImportController@saveImport')->name('save_import');