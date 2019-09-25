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

Route::get('/domain/doWhois/{domain}', 'DomainController@doWhois');
Route::resource('domain', 'DomainController');
Route::get('/ip/doReverseDns/{ip}', 'IpController@doReverseDns');
Route::resource('ip', 'IpController');
Route::resource('auditlog', 'AuditLogController');
Route::get('/zonefile/diff/{old}/{new}', 'ZoneFileController@diff');
Route::resource('zonefile', 'ZoneFileController');
Route::get('/website', 'WebsiteController@index');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
