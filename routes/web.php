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

// Domain routes
Route::get('/domain/doWhois/{domain}', 'DomainController@doWhois');
Route::post('/domain/{domain}', 'DomainController@addRecord')->name('dnsrecord.store');
Route::resource('domain', 'DomainController');

// IP routes
Route::get('/ip/{ip}/retryReverseDNS', 'IpController@retryReverseDNS')->name('retry.reversedns');
Route::get('/ip/{ip}/retryPortScan', 'IpController@retryPortScan')->name('retry.portscan');
Route::get('/ip/doReverseDns/{ip}', 'IpController@doReverseDns');
Route::resource('ip', 'IpController');

// Auditlog routes
Route::resource('auditlog', 'AuditLogController');

// Zonefile routes
Route::get('/zonefile/diff/{old}/{new}', 'ZoneFileController@diff');
Route::resource('zonefile', 'ZoneFileController');

// Website routes
Route::get('/website', 'WebsiteController@index')->name('website.index');
Route::get('/website/list', 'WebsiteController@list')->name('website.list');


// Defaullt routes
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
