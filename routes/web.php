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
    return redirect('login');
});

Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');

Route::get('/opengate', 'OpenGateController@index')->name('opengate');


Route::prefix('admin')->group(function () {
    Route::get('/index', 'HomeAdminController@index')->name('admin.index');
    Route::resource('kategori', 'KategoriAdminController');
});


Route::prefix('manager')->group(function () {
    Route::get('/index', 'HomeManagerController@index')->name('manager.index');
});


Route::prefix('supervisor')->group(function () {
    Route::get('/index', 'HomeSupervisorController@index')->name('supervisor.index');
});


Route::prefix('karyawan')->group(function () {
    Route::get('/index', 'HomeKaryawanController@index')->name('karyawan.index');
});