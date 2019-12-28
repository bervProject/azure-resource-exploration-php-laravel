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

Route::get('/', function () {
    return view('blob');
});

Route::get('/home', 'Blob\BlobViewerController@home');
Route::get('/blob/list', 'Blob\BlobViewerController@list');
Route::post('/blob/upload', 'Blob\BlobViewerController@upload');
Route::post('/cognitive/upload', 'Blob\BlobViewerController@uploadCognitive');
