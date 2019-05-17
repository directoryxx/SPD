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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/opengate', 'OpenGateController@index')->name('opengate');


Route::prefix('admin')->group(function () {
    Route::get('index', function () {
        return "hello,admin";
    });
});


Route::prefix('manager')->group(function () {
    Route::get('index', function () {
        return "hello,manager";
    });
});


Route::prefix('supervisor')->group(function () {
    Route::get('index', function () {
        return "hello,supervisor";
    });
});


Route::prefix('karyawan')->group(function () {
    Route::get('index', function () {
        return "hello,karyawan";
    });
});