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

Route::get('/', [
    'uses' => 'generalController@index',
    'as' => 'welcome'
]);

Route::get('/about', [
    'uses' => 'generalController@about',
    'as' => 'about'
]);

Route::get('/contact', [
    'uses' => 'generalController@contact',
    'as' => 'contact'
]);

Route::get('/verify-account/{token}', [
    'uses' => 'Auth\RegisterController@verification',
    'as' => 'verify.user'
]);

Route::group(['prefix' => '/course'], function(){
    Route::get('', [
        'uses' => 'generalController@course',
        'as' => 'course'
    ]);Route::get('{class}', [
        'uses' => 'generalController@courseOpsi',
        'as' => 'course.opsi'
    ]);
});

Route::get('/log', 'generalController@log')->name('log');
Route::get('/a', 'generalController@log')->name('axs');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/home/{$wilayah}', 'HomeController@index')->name('home');
