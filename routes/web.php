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
Route::get('/blob', function() {
    return view('blob-list');
})->name('blob-list');
Route::get('/cognitive', function () {
    return view('cognitive');
})->name('cognitive');
