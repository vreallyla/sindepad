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
    setlocale(LC_TIME, 'id');
    \Illuminate\Support\Facades\App::setlocale('id');

    Route::get('test1', function () {
        $title = 'Info Pembayaran';
        return view('user.order.invoice.order_inv_cod', compact('title'));
    });

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

    });

    Route::get('/kreu-token', [
        'uses' => 'generalController@cookie_token',
        'as' => 'create.token'
    ]);


    Route::get('/verify-account/{token}', [
        'uses' => 'Auth\RegisterController@verification',
        'as' => 'verify.user'
    ]);

    Route::post('/logout_now', [
        'uses' => 'generalController@logout',
        'as' => 'logout.jwt'
    ]);

    Route::group(['prefix' => '/order'], function () {

        Route::group(['middleware' => 'user_permissions'], function () {
            Route::get('detail', [
                'uses' => 'orderController@describe',
                'as' => 'order.describe',
            ]);
            Route::get('invoice', [
                'uses' => 'orderController@info',
                'as' => 'order.info',
            ]);

            Route::get('confirm', [
                'uses' => 'orderController@confirm',
                'as' => 'order.confirm',
            ]);
        });

        Route::get('method', [
            'uses' => 'orderController@method',
            'as' => 'order.method',
        ]);

        Route::get('register', [
            'uses' => 'orderController@order',
            'as' => 'order.step',
        ]);
        Route::post('register', [
            'uses' => 'orderController@overwrite',
            'as' => 'order.overwrite'
        ]);

        Route::get('checkout', [
            'uses' => 'orderController@checkout',
            'as' => 'order.checkout',
        ]);

        Route::post('first', [
            'uses' => 'orderController@first',
            'as' => 'order.first'
        ]);

//        Route::post('validation', [
//            'uses' => 'orderController@overwriteCheck',
//            'as' => 'order.validate'
//        ]);

        Route::get('check-day', [
            'uses' => 'orderController@checkDay',
            'as' => 'order.checkDay'
        ]);
        Route::get('check-program', [
            'uses' => 'orderController@checkProgram',
            'as' => 'order.checkProgram'
        ]);

    });


    Route::get('log/{id}', [
        'uses' => 'generalController@log',
        'as' => 'log',

    ]);
    Route::get('/a', 'generalController@log2')->name('axs');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/home/{$wilayah}', 'HomeController@index')->name('home');
