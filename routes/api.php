<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('import_parse', 'ImportController@parseImport')->name('import_parse');
Route::post('save_import', 'ImportController@saveImport')->name('save_import');
Route::post('generate_data', 'ImportController@generateData')->name('generate_data');

Route::post('record/edit/{id}', 'RecordController@edit')->name('record.edit');
Route::delete('record/delete/{id}', 'RecordController@destroy')->name('record.destroy');
Route::get('record/update_sldata/{recordId}/{slDay}', 'RecordController@updateShelfLifeData')->name('record.updateShelfLifeData');

Route::get('products', 'ProductController@index')->name('products');
Route::get('products/edit/{id}', 'ProductController@edit')->name('products.edit');
Route::post('products/store', 'ProductController@store')->name('products.store');
Route::delete('products/delete/{id}', 'ProductController@destroy')->name('products.destroy');

Route::get('locations', 'LocationController@index')->name('locations');
Route::get('locations/edit/{id}', 'LocationController@edit')->name('locations.edit');
Route::post('locations/store', 'LocationController@store')->name('locations.store');
Route::delete('locations/delete/{id}', 'LocationController@destroy')->name('locations.destroy');


Route::get('settings/users', 'SettingsController@getUsers')->name('settings.users');
Route::get('settings/devices', 'SettingsController@getDevices')->name('settings.devices');


