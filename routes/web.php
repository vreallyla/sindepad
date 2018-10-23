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

Route::group(['prefix' => '/'], function () {
//    setlocale(LC_TIME,'id');
//    \Illuminate\Support\Facades\App::setlocale('id');

    Route::group(['namespace' => 'User'], function () {

//      user part
        Route::group(['prefix' => 'profile'], function () {

//          profile view
            Route::get('/', [
                'uses' => 'ProfileController@index',
                'as' => 'user.profile',
                'middleware' => 'user_role'
            ]);

        });


    });

    //guest view
    Route::group(['middleware' => 'access'], function () {

        Route::get('/', [
            'uses' => 'generalController@index',
            'as' => 'welcome',

        ]);

        Route::get('/about', [
            'uses' => 'generalController@about',
            'as' => 'about'
        ]);

        Route::get('/contact', [
            'uses' => 'generalController@contact',
            'as' => 'contact'
        ]);
    });

    Route::get('/kreu-token', [
        'uses' => 'generalController@cookie_token',
        'as' => 'create.token'
    ]);


    Route::get('/verify-account/{token}', [
        'uses' => 'Auth\RegisterController@verification',
        'as' => 'verify.user'
    ]);

    Route::group(['prefix' => '/course'], function () {
        Route::get('', [
            'uses' => 'generalController@course',
            'as' => 'course'
        ]);
        Route::get('{class}', [
            'uses' => 'generalController@courseOpsi',
            'as' => 'course.opsi'
        ]);
    });

    Route::post('/logout_now', [
        'uses' => 'generalController@logout',
        'as' => 'logout.jwt'
    ]);


    Route::get('/order-step', [
        'uses' => 'OrderController@order',
        'as' => 'order.step',
        'middleware' => 'order'
    ]);

    Route::post('/order-first', [
        'uses' => 'orderController@first',
        'as' => 'order.first'
    ]);


    Route::get('/log', 'generalController@log')->name('log');
    Route::get('/a', 'generalController@log2')->name('axs');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/home/{$wilayah}', 'HomeController@index')->name('home');
