<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//$router->get('/api', function () use ($router) {
//    return view('welcome');
//});

//$router->group(['prefix' => 'api','middleware' => 'anu'], function () use ($router) {
//
//    $router->get('abc', [
//        'as' => 'ab',
//        'uses' => 'cobaController@index'
//    ]);
//    $router->get('/ac', function () use ($router) {
//        return redirect()->route('ab');
//
//    });
//
//    $router->get('/az', ['middleware' => 'role:editor', function ($id) {
//        //
//    }]);
//co
//});

Route::group(['prefix' => '/api'], function () {

    Route::get('/a', [
        'uses' => 'cobaController@index',
        'as' => 'aku',
    ]);

    Route::post('/', [
        'uses' => 'ClassListController@getIndex',
        'as' => 'welcomePost'
    ]);

//    user role
    Route::group(['middleware' => 'api_user', 'namespace' => 'User'], function () {

//        menu profile
        Route::group(['prefix' => 'profile'], function () {

            //profile data
            Route::post('change-photo', [
                'uses' => 'profileController@edit_photo',
                'as' => 'edit.photo'
            ]);
            Route::post('change-profile', [
                'uses' => 'profileController@edit_profile',
                'as' => 'edit.profile'
            ]);
            Route::post('change-password', [
                'uses' => 'profileController@edit_password',
                'as' => 'edit.password'
            ]);

            //data anak
            Route::get('get-kid', [
                'uses' => 'kidController@get_kid',
                'as' => 'get.kid'
            ]);
        });

        Route::group(['prefix' => '/order'], function () {
            Route::post('register-validation', [
                'uses' => 'orderSeatController@overwriteCheck',
                'as' => 'api.order.register.check'
            ]);
            Route::post('register', [
                'uses' => 'orderSeatController@overwrite',
                'as' => 'api.order.register.save'
            ]);
            Route::group(['prefix' => '/checkout'], function () {
                Route::get('get', [
                    'uses' => 'orderSeatController@seeCheckout',
                    'as' => 'api.order.checkout'
                ]);
                Route::post('voucher', [
                    'uses' => 'orderSeatController@checkCode',
                    'as' => 'api.order.voucher',
                ]);
                Route::post('post-confirm', [
                    'uses' => 'orderSeatController@confirmPost',
                    'as' => 'api.order.confirmPost',
                    'middleware' => 'confirm_confirm_handdler'
                ]);

                Route::post('confirm-payment', [
                    'uses' => 'orderSeatController@confirmPayment',
                    'as' => 'api.order.confirmPayment',
                    'middleware' => 'confirm_payment_handdler'
                ]);
                Route::post('change-method', [
                    'uses' => 'orderSeatController@methodChange',
                    'as' => 'api.order.methodChange',
                    'middleware' => 'confirm_payment_handdler'
                ]);
                Route::post('delete-trans', [
                    'uses' => 'orderSeatController@transDelete',
                    'as' => 'api.order.transDelete',
                    'middleware' => 'confirm_payment_handdler'
                ]);
            });

        });

    });


    Route::post('/send-feedback', [
        'uses' => 'contactController@sendFromUser',
        'as' => 'api.sendFeedback'
    ]);

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', [
            'uses' => 'AuthController@login',
            'as' => 'loginjwt'
        ]);
        Route::post('logout', [
            'uses' => 'AuthController@logout',
            'as' => 'logoutjwt'
        ]);
        Route::post('refresh', [
            'uses' => 'AuthController@refresh',
            'as' => 'refreshjwt'
        ]);
        Route::post('me', [
            'uses' => 'AuthController@me',
            'as' => 'mejwt',
        ]);
//        Route::post('login', 'AuthController@login');
//        Route::post('logout', 'AuthController@logout');
//        Route::post('refresh', 'AuthController@refresh');
//        Route::post('me', 'AuthController@me');

    });

});

