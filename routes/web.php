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

Route::get('/mailtest', 'MailController@index')->name('mail');


Route::prefix('admin')->group(function () {
    Route::get('/index', 'HomeAdminController@index')->name('admin.index');
    Route::resource('kategori', 'KategoriAdminController');
    Route::resource('users', 'UserAdminController');
});


Route::prefix('manager')->group(function () {
    Route::get('/index', 'HomeManagerController@index')->name('manager.index');
    Route::resource('createproject', 'CreateProjectController');
    Route::get('/proyek/{id}', 'ProjectManagerController@index')->name('manager.detailproyek');
    Route::post('/proyek/{id}','ProjectManagerController@accept')->name('manager.accept');
    Route::post('/fileproyek/accept/','HomeManagerController@acceptdokumen')->name('manager.acceptfile');
    Route::post('/fileproyek/reject/','HomeManagerController@rejectdokumen')->name('manager.rejectfile');
});


Route::prefix('supervisor')->group(function () {
    Route::get('/index', 'HomeSupervisorController@index')->name('supervisor.index');
    Route::get('/detailproyek/{id}', 'HomeSupervisorController@proyekhandlespv')->name('supervisor.detailproyek');
    Route::post('/detailproyek/{id}','HomeSupervisorController@insertkaryawan')->name('supervisor.pilihkaryawan');
    Route::post('/fileproyek/accept/','HomeSupervisorController@acceptdokumen')->name('supervisor.acceptfile');
    Route::post('/fileproyek/reject/','HomeSupervisorController@rejectdokumen')->name('supervisor.rejectfile');
    Route::post('/uploaddokumen','HomeSupervisorController@fileUpload')->name('supervisor.fileupload');
});


Route::prefix('karyawan')->group(function () {
    Route::get('/index', 'HomeKaryawanController@index')->name('karyawan.index');
    Route::post('/uploaddokumen','HomeKaryawanController@fileUpload')->name('karyawan.fileupload');
});

Route::get('/proyekselesai', 'ProyekselesaiController@index')->name('proyekselesai.index');
Route::get('/proyekselesai/{id}', 'ProyekselesaiController@detail')->name('proyekselesai.detail');
Route::get('/test/{id}', 'TestController@index')->name('testproyekdetail.index');
Route::get('/test2/{id}', 'TestController@test')->name('testproyekdetail.index2');