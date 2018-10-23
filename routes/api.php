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
        'as' => 'aku'
    ]);

    Route::post('/', [
        'uses' => 'ClassListController@getIndex',
        'as' => 'welcomePost'
    ]);

//    user role
    Route::group(['namespace' => 'User'], function () {

//        menu profile
        Route::group(['middleware'=>'api_user','prefix' => 'profile'], function () {

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

    Route::group(['prefix' => '/order'], function () {
        Route::post('-overwrite', [
            'uses' => 'OrderController@overwrite',
            'as' => 'api.order.overwrite'
        ]);
    });

});

