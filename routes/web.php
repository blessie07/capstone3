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

Route::middleware('auth')->group(function () {
    Route::resource('/', 'ToDoController');
    Route::get('/updateStatus/{id}', 'ToDoController@updateStatus')->name('updateStatus');
    Route::post('/sendInvitation', 'ToDoController@sendInvitation')->name('sendInvitation');
    Route::get('/acceptInvitation/{id}', 'ToDoController@acceptInvitation')->name('acceptInvitation');
    Route::get('/denyInvitation/{id}', 'ToDoController@denyInvitation')->name('denyInvitation');
    Route::get('/deleteWorker/{id}', 'ToDoController@deleteWorker')->name('deleteWorker');
    Route::get('/edit/{id}', 'ToDoController@edit')->name('edit');
    Route::post('/update/{id}', 'ToDoController@update')->name('update');
    Route::get('/delete/{id}','ToDoController@destroy')->name('destroy');

});




Auth::routes();


