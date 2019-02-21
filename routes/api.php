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

Route::group(['prefix' => '/api/v1/'], function () {

    Route::get('/a', [
        'uses' => 'Admin\settings\shadowController@getNotif',
        'as' => 'aku',
    ]);

    Route::post('/', [
        'uses' => 'ClassListController@getIndex',
        'as' => 'welcomePost'
    ]);

    //fundraising
    Route::group(['prefix' => '/fundraising'], function () {
        Route::post('post', [
            'uses' => 'Admin\fundraising\fundraisingContController@postContributor',
            'as' => 'api.public.postCont'
        ]);
    });


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

    //admin role
    Route::group(['middleware' => 'api_admin', 'prefix' => 'admin'], function () {
        Route::group(['prefix' => 'profile', 'namespace' => 'Shadow'], function () {
            Route::put('change-photo', [
                'uses' => 'sideShadowController@changePhoto',
                'as' => 'api.shadow.side.changePhoto'
            ]);
            Route::put('update-profil', [
                'uses' => 'sideShadowController@updateProfile',
                'as' => 'api.shadow.side.updateProfile'
            ]);
            Route::put('change-password', [
                'uses' => 'sideShadowController@updatePass',
                'as' => 'api.shadow.side.updatePass'
            ]);
        });
        Route::group(['namespace' => 'Admin'], function () {
            /*------------------------------------- realtime notice -------------------------------------*/
            Route::group(['prefix' => 'notice-check'], function () {
                Route::get('transactions', [
                    'uses' => 'Trans\orderSignController@getNotif',
                    'as' => 'api.admin.notif.trans'
                ]);
                Route::get('shadow', [
                    'uses' => 'settings\shadowController@getNotif',
                    'as' => 'api.admin.notif.shadow'
                ]);
            });
            /*----------------------------------- end realtime notice -----------------------------------*/

            Route::group(['prefix' => 'fundraising', 'namespace' => 'fundraising'], function () {
                Route::get('list', [
                    'uses' => 'fundraisingContController@getList',
                    'as' => 'api.admin.fundraising.cont.list'
                ]);
                Route::put('change', [
                    'uses' => 'fundraisingContController@sendCHage',
                    'as' => 'api.admin.fundraising.cont.change'
                ]);
                Route::post('post', [
                    'uses' => 'fundraisingContController@postStatSuc',
                    'as' => 'api.admin.fundraising.cont.post'
                ]);
            });

            Route::group(['prefix' => 'transactions', 'namespace' => 'Trans'], function () {
                Route::get('register-list', [
                    'uses' => 'orderSignController@getList',
                    'as' => 'api.admin.trans.sign.list'
                ]);
                Route::get('register-detail', [
                    'uses' => 'orderSignController@getDetail',
                    'as' => 'api.admin.trans.sign.detail'
                ]);
                Route::post('register-confirm', [
                    'uses' => 'orderSignController@postConfirm',
                    'as' => 'api.admin.trans.sign.confirm'
                ]);
                Route::post('new-register', [
                    'uses' => 'orderSignController@create',
                    'as' => 'api.admin.trans.sign.new'
                ]);

                Route::group(['prefix' => 'tuitions'], function () {
                    Route::get('list', [
                        'uses' => 'tuitionsController@getList',
                        'as' => 'api.admin.trans.sign.getList'
                    ]);
                    Route::put('deal', [
                        'uses' => 'tuitionsController@deals',
                        'as' => 'api.admin.trans.sign.deals'
                    ]);
                });
            });
            Route::group(['prefix' => 'settings', 'namespace' => 'settings'], function () {
                Route::post('aggrement-post', [
                    'uses' => 'aggrementController@post',
                    'as' => 'api.admin.settings.aggre.post'
                ]);

                /*--------------------------------------- shadow set ----------------------------------------*/
                Route::get('shadows-list', [
                    'uses' => 'shadowController@getList',
                    'as' => 'api.admin.settings.shadow.list'
                ]);
                Route::put('shadows-change', [
                    'uses' => 'shadowController@change',
                    'as' => 'api.admin.settings.shadow.change'
                ]);
                /*------------------------------------- end shadow set --------------------------------------*/

                Route::group(['prefix' => 'voucher'], function () {
                    Route::get('list', [
                        'uses' => 'voucherController@getList',
                        'as' => 'api.admin.settings.voucher.list'
                    ]);
                    Route::delete('delete', [
                        'uses' => 'voucherController@setDel',
                        'as' => 'api.admin.settings.voucher.delete'
                    ]);
                    Route::put('update', [
                        'uses' => 'voucherController@setUpdate',
                        'as' => 'api.admin.settings.voucher.update'
                    ]);
                    Route::post('create', [
                        'uses' => 'voucherController@sendPost',
                        'as' => 'api.admin.settings.voucher.post'
                    ]);
                    Route::get('edit', [
                        'uses' => 'voucherController@getEdit',
                        'as' => 'api.admin.settings.voucher.edit'
                    ]);
                });


                /*--------------------------------------- bank set ----------------------------------------*/

                Route::group(['prefix' => 'method-payment-set'], function () {
                    Route::get('list', [
                        'uses' => 'setBankController@getList',
                        'as' => 'api.admin.settings.bank.list'
                    ]);
                    Route::post('create', [
                        'uses' => 'setBankController@sendPost',
                        'as' => 'api.admin.settings.bank.create'
                    ]);
                    Route::patch('update', [
                        'uses' => 'setBankController@setUpdate',
                        'as' => 'api.admin.settings.bank.update'
                    ]);
                    Route::get('edit', [
                        'uses' => 'setBankController@getEdit',
                        'as' => 'api.admin.settings.bank.edit'
                    ]);
                    Route::delete('delete', [
                        'uses' => 'setBankController@setDel',
                        'as' => 'api.admin.settings.bank.delete'
                    ]);
                });
                /*------------------------------------- end bank set --------------------------------------*/


                /*--------------------------------------- slides----------------------------------------*/
                Route::group(['prefix' => 'slides'], function () {
                    Route::post('post', [
                        'uses' => 'slidesController@post',
                        'as' => 'api.admin.settings.slides.post'
                    ]);
                    Route::get('list', [
                        'uses' => 'slidesController@getList',
                        'as' => 'api.admin.settings.slides.list'
                    ]);
                    Route::get('edit', [
                        'uses' => 'slidesController@getedit',
                        'as' => 'api.admin.settings.slides.edit'
                    ]);
                    Route::patch('update', [
                        'uses' => 'slidesController@change',
                        'as' => 'api.admin.settings.slides.change'
                    ]);
                    Route::delete('delete', [
                        'uses' => 'slidesController@del',
                        'as' => 'api.admin.settings.slides.del'
                    ]);
                });
                /*------------------------------------- end slides--------------------------------------*/

                /*--------------------------------------- price----------------------------------------*/
                Route::group(['prefix' => 'prices'], function () {
                    Route::get('list', [
                        'uses' => 'priceController@getList',
                        'as' => 'api.admin.settings.prices.list'
                    ]);
                    Route::put('update', [
                        'uses' => 'priceController@Sendupdate',
                        'as' => 'api.admin.settings.prices.update'
                    ]);
                });
                /*------------------------------------- end price--------------------------------------*/


            });

            Route::group(['prefix' => 'fundraising', 'namespace' => 'fundraising'], function () {
                Route::group(['prefix' => 'record'], function () {
                    Route::get('list', [
                        'uses' => 'fundraisingRecordController@getList',
                        'as' => 'api.admin.fundraising.list'
                    ]);
                    Route::get('key', [
                        'uses' => 'fundraisingRecordController@getCat',
                        'as' => 'api.admin.fundraising.cat'
                    ]);
                    Route::get('edit', [
                        'uses' => 'fundraisingRecordController@getEdit',
                        'as' => 'api.admin.fundraising.edit'
                    ]);
                    Route::post('post', [
                        'uses' => 'fundraisingRecordController@sendPost',
                        'as' => 'api.admin.fundraising.post'
                    ]);
                    Route::patch('update', [
                        'uses' => 'fundraisingRecordController@sendUpdate',
                        'as' => 'api.admin.fundraising.update'
                    ]);
                    Route::delete('delete', [
                        'uses' => 'fundraisingRecordController@del',
                        'as' => 'api.admin.fundraising.delete'
                    ]);
                });
            });

            Route::group(['prefix' => 'news', 'namespace' => 'news'], function () {
                Route::group(['prefix' => 'record'], function () {
                    Route::post('post', [
                        'uses' => 'newsListController@sendPost',
                        'as' => 'api.admin.news.record.post'
                    ]);
                    Route::get('key', [
                        'uses' => 'newsListController@getKey',
                        'as' => 'api.admin.news.record.key'
                    ]);
                    Route::get('list', [
                        'uses' => 'newsListController@getList',
                        'as' => 'api.admin.news.record.list'
                    ]);
                    Route::get('edit', [
                        'uses' => 'newsListController@getEdit',
                        'as' => 'api.admin.news.record.edit'
                    ]);
                    Route::patch('update', [
                        'uses' => 'newsListController@sendUpdate',
                        'as' => 'api.admin.news.record.update'
                    ]);
                    Route::delete('delete', [
                        'uses' => 'newsListController@del',
                        'as' => 'api.admin.news.record.delete'
                    ]);
                });
                Route::group(['prefix' => 'categories'], function () {
                    Route::post('post', [
                        'uses' => 'NewsCategoriesController@sendPost',
                        'as' => 'api.admin.news.categories.post'
                    ]);
                    Route::get('list', [
                        'uses' => 'NewsCategoriesController@getList',
                        'as' => 'api.admin.news.categories.list'
                    ]);
                    Route::get('edit', [
                        'uses' => 'NewsCategoriesController@getEdit',
                        'as' => 'api.admin.news.categories.edit'
                    ]);
                    Route::put('update', [
                        'uses' => 'NewsCategoriesController@sendUpdate',
                        'as' => 'api.admin.news.categories.update'
                    ]);
                    Route::delete('delete', [
                        'uses' => 'NewsCategoriesController@del',
                        'as' => 'api.admin.news.categories.delete'
                    ]);
                });

            });

            Route::group(['prefix' => 'student-config', 'namespace' => 'studentConfig'], function () {
                /*------------------------------------- activities -------------------------------------*/
                Route::get('sub-activity-detail', [
                    'uses' => 'activitiesController@sub',
                    'as' => 'api.admin.studentConfig.activities.sub'
                ]);
                Route::put('sub-activity-edit', [
                    'uses' => 'activitiesController@subEdit',
                    'as' => 'api.admin.studentConfig.activities.subEdit'
                ]);
                Route::put('sub-activity-delete', [
                    'uses' => 'activitiesController@subDel',
                    'as' => 'api.admin.studentConfig.activities.subDel'
                ]);
                Route::get('activity-edit', [
                    'uses' => 'activitiesController@actEdit',
                    'as' => 'api.admin.studentConfig.activities.actEdit'
                ]);
                Route::patch('activity-update', [
                    'uses' => 'activitiesController@actUpdate',
                    'as' => 'api.admin.studentConfig.activities.actUpdate'
                ]);
                Route::delete('activity-delete', [
                    'uses' => 'activitiesController@actDel',
                    'as' => 'api.admin.studentConfig.activities.actDel'
                ]);
                Route::post('sub-activity-post', [
                    'uses' => 'activitiesController@subPost',
                    'as' => 'api.admin.studentConfig.activities.subPost'
                ]);
                Route::get('activity-list', [
                    'uses' => 'activitiesController@getList',
                    'as' => 'api.admin.studentConfig.activities.list'
                ]);
                Route::get('activity-detail', [
                    'uses' => 'activitiesController@detail',
                    'as' => 'api.admin.studentConfig.activities.detail'
                ]);
                Route::post('activity-post', [
                    'uses' => 'activitiesController@post',
                    'as' => 'api.admin.studentConfig.activities.post'
                ]);
                /*----------------------------------- end activities -----------------------------------*/
                /*------------------------------------- schedules --------------------------------------*/
                Route::group(['prefix' => 'schedules', 'namespace' => 'schedules'], function () {
                    Route::get('list', [
                        'uses' => 'schedulesController@ScheGetList',
                        'as' => 'api.admin.studentConfig.schedules.listSche'
                    ]);
                    Route::get('detail', [
                        'uses' => 'schedulesController@sideGetList',
                        'as' => 'api.admin.studentConfig.schedules.detailSche'
                    ]);
                    Route::get('edit', [
                        'uses' => 'schedulesController@editSche',
                        'as' => 'api.admin.studentConfig.schedules.editSche'
                    ]);

                    Route::post('post', [
                        'uses' => 'schedulesController@postSche',
                        'as' => 'api.admin.studentConfig.schedules.postSche'
                    ]);
                    Route::post('post-act', [
                        'uses' => 'schedulesController@postAct',
                        'as' => 'api.admin.studentConfig.schedules.postAct'
                    ]);
                    Route::put('update', [
                        'uses' => 'schedulesController@updateSche',
                        'as' => 'api.admin.studentConfig.schedules.updateSche'
                    ]);
                    Route::put('update-act', [
                        'uses' => 'schedulesController@updateAct',
                        'as' => 'api.admin.studentConfig.schedules.updateAct'
                    ]);
                    Route::delete('delete', [
                        'uses' => 'schedulesController@delSche',
                        'as' => 'api.admin.studentConfig.schedules.deleteSche'
                    ]);

                    Route::delete('delete-act', [
                        'uses' => 'schedulesController@deleteAct',
                        'as' => 'api.admin.studentConfig.schedules.deleteAct'
                    ]);
                });

                /*----------------------------------- end schedules ------------------------------------*/


            });

            Route::group(['prefix' => 'master', 'namespace' => 'master'], function () {
                Route::get('users', [
                    'uses' => 'userListController@getList',
                    'as' => 'api.admin.master.users.list'
                ]);
                Route::get('user-detail', [
                    'uses' => 'userListController@user_detail',
                    'as' => 'api.admin.master.user.detail'
                ]);
                Route::post('make-user', [
                    'uses' => 'userListController@create',
                    'as' => 'api.admin.master.user.create'
                ]);
            });
        });
    });

    //shadow role
    Route::group([/*'middleware' => 'api_admin',*/
        'prefix' => 'shadow'], function () {

        Route::group(['prefix' => 'evaluation', 'namespace' => 'Shadow'], function () {
            Route::get('/detail', [
                'uses' => 'evaluationsController@desc',
                'as' => 'api.evaluations.desc',
            ]);
            Route::put('/save', [
                'uses' => 'evaluationsController@sendPost',
                'as' => 'api.evaluations.post',
            ]);
        });

        Route::group(['prefix' => 'check-notice', 'namespace' => 'Shadow'], function () {
            Route::get('/student', [
                'uses' => 'setScheStudentController@checkRequest',
                'as' => 'api.check_notice.student',
            ]);
            Route::get('/monitoring', [
                'uses' => 'monitoringController@getRequest',
                'as' => 'api.check_notice.monitoring',
            ]);
        });

        Route::group(['prefix' => 'activities', 'namespace' => 'Admin\studentConfig'], function () {
            Route::get('sub-activity-detail', [
                'uses' => 'activitiesController@sub',
                'as' => 'api.admin.studentConfig.activities.sub'
            ]);
            Route::get('activity-list', [
                'uses' => 'activitiesController@getList',
                'as' => 'api.admin.studentConfig.activities.list'
            ]);
            Route::get('activity-detail', [
                'uses' => 'activitiesController@detail',
                'as' => 'api.admin.studentConfig.activities.detail'
            ]);
        });

        Route::group(['prefix' => 'schedules', 'namespace' => 'Admin\studentConfig\schedules'], function () {
            Route::get('list', [
                'uses' => 'schedulesController@ScheGetList',
                'as' => 'api.admin.studentConfig.schedules.listSche'
            ]);
            Route::get('detail', [
                'uses' => 'schedulesController@sideGetList',
                'as' => 'api.admin.studentConfig.schedules.detailSche'
            ]);
        });

        Route::group(['prefix' => 'set-schedules', 'namespace' => 'Shadow'], function () {
            Route::get('list', [
                'uses' => 'setScheStudentController@getList',
                'as' => 'api.shadow.setSche.list'
            ]);
            Route::put('update', [
                'uses' => 'setScheStudentController@setSche',
                'as' => 'api.shadow.setSche.update'
            ]);
        });

        Route::group(['prefix' => 'data-graphs', 'namespace' => 'Shadow'], function () {
            Route::get('get', [
                'uses' => 'chartController@getGraph',
                'as' => 'api.shadow.graph.get'
            ]);
        });

        Route::group(['prefix' => 'monitoring', 'namespace' => 'Shadow'], function () {
            Route::get('list', [
                'uses' => 'monitoringController@getList',
                'as' => 'api.shadow.monitoring.list'
            ]);
            Route::put('update', [
                'uses' => 'monitoringController@sendUpdate',
                'as' => 'api.shadow.monitoring.update'
            ]);
            Route::post('create', [
                'uses' => 'monitoringController@sendPost',
                'as' => 'api.shadow.monitoring.create'
            ]);
        });

        Route::group(['prefix' => 'profile', 'namespace' => 'Shadow'], function () {
            Route::put('change-photo', [
                'uses' => 'sideShadowController@changePhoto',
                'as' => 'api.shadow.side.changePhoto'
            ]);

            Route::put('update-profil', [
                'uses' => 'sideShadowController@updateProfile',
                'as' => 'api.shadow.side.updateProfile'
            ]);

            Route::put('change-password', [
                'uses' => 'sideShadowController@updatePass',
                'as' => 'api.shadow.side.updatePass'
            ]);
        });


//        Route::get('users', [
//            'uses' => 'Admin\master\userListController@getList',
//            'as' => 'api.shadow.users'
//        ]);

        Route::group(['prefix' => 'master', 'namespace' => 'Admin\master'], function () {
            Route::get('users', [
                'uses' => 'userListController@getList',
                'as' => 'api.admin.master.users.list'
            ]);
            Route::get('user-detail', [
                'uses' => 'userListController@user_detail',
                'as' => 'api.admin.master.user.detail'
            ]);
            Route::post('make-user', [
                'uses' => 'userListController@create',
                'as' => 'api.admin.master.user.create'
            ]);
        });
    });

//user in
    Route::group(['prefix' => 'user'], function () {
        Route::group(['prefix' => 'monitoring', 'namespace' => 'User\In'], function () {
            Route::get('list', [
                'uses' => 'monitoringController@getList',
                'as' => 'api.user.monitoring.list'
            ]);
        });

        Route::group(['prefix' => 'profile'], function () {

            Route::group(['namespace' => 'User\In'], function () {

                Route::put('update-profil', [
                    'uses' => 'profileInUserController@editProfile',
                    'as' => 'api.user.side.profile.edit'
                ]);

                Route::get('kids', [
                    'uses' => 'profileInUserController@kids',
                    'as' => 'api.user.side.profile.kids'
                ]);
                Route::get('kid-detail', [
                    'uses' => 'profileInUserController@kidDetail',
                    'as' => 'api.user.side.profile.kidDetail'
                ]);
                Route::put('change-photo-student',[
                    'uses' => 'profileInUserController@changePhotoKid',
                    'as' => 'api.user.side.profile.changePhotoKid'
                ]);

                Route::put('edit-student',[
                    'uses' => 'profileInUserController@editKid',
                    'as' => 'api.user.side.profile.editKid'
                ]);
            });

            Route::group(['namespace' => 'Shadow'], function () {
                Route::put('change-photo', [
                    'uses' => 'sideShadowController@changePhoto',
                    'as' => 'api.user.side.changePhoto'
                ]);
                Route::put('change-password', [
                    'uses' => 'sideShadowController@updatePass',
                    'as' => 'api.shadow.side.updatePass'
                ]);


            });
        });


        Route::group(['prefix' => 'data-graphs', 'namespace' => 'Shadow'], function () {
            Route::get('get', [
                'uses' => 'chartController@getFromParent',
                'as' => 'api.user.graph.get'
            ]);
        });
        Route::group(['prefix' => 'activities', 'namespace' => 'Admin\studentConfig'], function () {
            Route::get('sub-activity-detail', [
                'uses' => 'activitiesController@sub',
                'as' => 'api.admin.studentConfig.activities.sub'
            ]);
            Route::get('activity-list', [
                'uses' => 'activitiesController@getList',
                'as' => 'api.admin.studentConfig.activities.list'
            ]);
            Route::get('activity-detail', [
                'uses' => 'activitiesController@detail',
                'as' => 'api.admin.studentConfig.activities.detail'
            ]);
        });
        Route::group(['prefix' => 'schedules', 'namespace' => 'User\In'], function () {
            Route::get('list', [
                'uses' => 'userScheController@getList',
                'as' => 'api.user.sche.list'
            ]);

        });

        Route::group(['prefix' => 'evaluation', 'namespace' => 'User\In'], function () {
            Route::get('/detail', [
                'uses' => 'evaluationController@desc',
                'as' => 'api.user.evaluations.desc',
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

});

