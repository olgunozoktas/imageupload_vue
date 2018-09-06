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
    return view('welcome');
});

Route::post('upload', 'ImageController@upload')->name('upload');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// With.save.image
Route::view('saveImage', 'showSaveImage');
Route::post('saveImage','ImageController@saveImage');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
