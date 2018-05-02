<?php
/**
 * Copyright (c) 2018. Bobby Syahronanda
 * Name : Bobby Syahronanda., MTA
 * Email  : Bobbysyahronanda@gmail.com
 * Today : 3/14/18 3:09 PM
 */



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

Route::resource('data','DataController');
Route::resource('proses','ProsesController');
Route::get('proses','ProsesController@index');
Route::get('hapus', 'DataController@destroy');
Route::get('tes', 'ProsesController@wew');
Route::get('tesdata', 'DataController@tesdata');
//Route::post('prosesdata', 'ProsesController@proses');


