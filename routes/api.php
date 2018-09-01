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

Route::group(['prefix' => '/api'], function(){
    Route::get('/a', [
        'uses' => 'cobaController@index',
        'as' => 'aku'
    ]);

    Route::post('/', [
        'uses' => 'ClassListController@getIndex',
        'as' => 'welcomePost'
    ]);

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });
});

