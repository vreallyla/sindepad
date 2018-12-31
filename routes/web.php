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

    Route::get('privacy-policy', [
        'uses' => 'generalController@privacy',
            'as' => 'privacy',
    ]);

    Route::get('redirect',[
        'uses' => 'generalController@privacy',
        'as' => 'redirect',
        'middleware'=>['order','redirectLogin']
    ]);

    Route::post('signout', [
        'uses' => 'generalController@signout',
        'as' => 'user.signout',
    ]);

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

        Route::group(['prefix' => '/blog'], function () {
            Route::get('', [
                'uses' => 'blogController@index',
                'as' => 'blog.all'
            ]);
            Route::get('{blog}', [
                'uses' => 'blogController@single',
                'as' => 'blog.single'
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

        Route::get('check-day', [
            'uses' => 'orderController@checkDay',
            'as' => 'order.checkDay'
        ]);
        Route::get('check-program', [
            'uses' => 'orderController@checkProgram',
            'as' => 'order.checkProgram'
        ]);

    });

    Route::group(['prefix' => 'simdepad'], function () {
        Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function () {
            Route::get('/', [
                'uses' => 'AdminController@index',
                'as' => 'admin.index'
            ]);

            Route::get('side/profile', [
                'uses' => 'AdminController@sideProfile',
                'as' => 'admin.profile'
            ]);
            Route::group(['prefix' => 'transactions'], function () {

                Route::get('register-list', [
                    'uses' => 'AdminController@register',
                    'as' => 'admin.register'
                ]);
                Route::get('monthly-tuition', [
                    'uses' => 'AdminController@tuition',
                    'as' => 'admin.trans.tuition'
                ]);
            });

            Route::group(['prefix' => 'news'], function () {
                Route::get('categories', [
                    'uses' => 'AdminController@newsCategory',
                    'as' => 'admin.news.category'
                ]);

                Route::get('list', [
                    'uses' => 'AdminController@newsList',
                    'as' => 'admin.news.list'
                ]);
            });

            Route::group(['prefix' => 'settings'], function () {
                Route::get('aggrement-set', [
                    'uses' => 'AdminController@aggre',
                    'as' => 'admin.settings.aggre'
                ]);

                Route::get('discon-set', [
                    'uses' => 'AdminController@discon',
                    'as' => 'admin.discon'
                ]);

                Route::get('price-set', [
                    'uses' => 'AdminController@price',
                    'as' => 'admin.settings.price'
                ]);

                Route::get('carousels-set', [
                    'uses' => 'AdminController@slide',
                    'as' => 'admin.settings.slide'
                ]);

                Route::get('banks-set', [
                    'uses' => 'AdminController@loadBank',
                    'as' => 'admin.settings.bank'
                ]);
            });
            Route::group(['prefix' => 'student-config'], function () {
                Route::get('shadow', [
                    'uses' => 'AdminController@shadow',
                    'as' => 'admin.student.shadow'
                ]);
                Route::get('activities', [
                    'uses' => 'AdminController@activity',
                    'as' => 'admin.student.activity'
                ]);
                Route::get('schedules', [
                    'uses' => 'AdminController@schedule',
                    'as' => 'admin.student.schedule'
                ]);
            });

            Route::group(['prefix' => 'data-master'], function () {
                Route::get('users', [
                    'uses' => 'AdminController@users',
                    'as' => 'admin.master.users'
                ]);
            });
        });


        Route::group(['namespace' => 'Simdepad'], function () {

            Route::group(['prefix' => 'shadow'], function () {
                Route::get('/', [
                    'uses' => 'shadowController@index',
                    'as' => 'shadow.index',
                ]);
                Route::get('users', [
                    'uses' => 'shadowController@users',
                    'as' => 'shadow.users',
                ]);

                Route::get('monitoring', [
                    'uses' => 'shadowController@tracking',
                    'as' => 'shadow.tracking',
                ]);

                Route::group(['prefix' => 'schedules'], function () {
                    Route::get('list', [
                        'uses' => 'shadowController@scheList',
                        'as' => 'shadow.sche.list',
                    ]);
                    Route::get('activities', [
                        'uses' => 'shadowController@scheAct',
                        'as' => 'shadow.sche.act',
                    ]);
                    Route::get('student', [
                        'uses' => 'shadowController@scheStudent',
                        'as' => 'shadow.sche.student',
                    ]);
                });

                Route::group(['prefix' => 'side'], function () {
                    Route::get('profile', [
                        'uses' => 'shadowController@sideProfile',
                        'as' => 'shadow.side.profile',
                    ]);
                });

            });

            Route::group(['prefix' => 'user'], function () {
                Route::get('monitoring', [
                    'uses' => 'userInController@tracking',
                    'as' => 'user.tracking',
                ]);

                Route::get('/', [
                    'uses' => 'userInController@index',
                    'as' => 'user.in.home'
                ]);

                Route::group(['prefix' => 'side'], function () {
                    Route::get('profile', [
                        'uses' => 'userInController@profile',
                        'as' => 'user.side.profile',
                    ]);
                });

                    Route::group(['prefix' => 'schedules'], function () {
                    Route::get('list', [
                        'uses' => 'userInController@scheList',
                        'as' => 'user.sche.list',
                    ]);
                    Route::get('activities', [
                        'uses' => 'userInController@scheAct',
                        'as' => 'user.sche.act',
                    ]);
                });

            });


        });
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
