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

Route::get('/home', 'Blob\BlobViewerController@home')->name('home');
Route::get('/blob', 'Blob\BlobViewerController@list')->name('blob-list');
Route::post('/blob/upload', 'Blob\BlobViewerController@upload')->name('blob-uploader');
Route::post('/cognitive/upload', 'Blob\BlobViewerController@uploadCognitive')->name('cognitive-uploader');
