<?php

use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
});

Route::get('importExportView', 'MyController@importExportView');
Route::get('export', 'MyController@export')->name('export');
Route::post('import', 'MyController@import')->name('import');

Route::resource('workers', workerController::class);
Route::get('get-workers', 'workerController@getWorkers')->name('get-workers');

Route::get('export', 'workerController@export')->name('export');
Route::match(['get','post'], 'import', 'workerController@import')->name('import');
Route::get('exportPDF', 'workerController@exportPDF')->name('exportPDF');
// Route::get('generate-pdf','workerController@generatePDF')->name('generate-pdf');
