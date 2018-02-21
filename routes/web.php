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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
    // Get time until timeout
    // It's outside the timeout middleware, otherwise it will reset the timer
    Route::get('/ajax/session', 'SessionController@get');

    Route::group(['middleware' => 'timeout'], function () {
       // Dummy to reset timeout:
       Route::put('/ajax/session', 'SessionController@put');

        Route::view('/member', 'user.memberslist');
        Route::view('/dashboard', 'dashboard');

        Route::group(['prefix'=>'api', 'namespace'=>'Api'], function () {
            Route::get('/dashboard', 'DashboardController@index');

            Route::get('/event', 'EventController@index');
            Route::post('event/notify/{id}', 'EventController@notify');
            Route::get('event/{id}/members', 'EventController@members');
            Route::resource('event', 'EventController',
                ['only'=>['store', 'update', 'destroy']]
            );

            Route::get('/member', 'UserController@index');
            Route::put('/member/{id}', 'UserController@update');
            Route::get('member/{id}/membership', 'UserController@membership');
            Route::get('member/{id}/yes', 'UserController@yes_responses');
            Route::post('member/{id}/proxySignup', 'UserController@proxy_signup');
            Route::get('member/signups/{eventid}', 'UserController@signups');
            Route::post('member/eventpay/{eventid}', 'UserController@pay');
            Route::post('member/{id}/avatar', 'UserController@avatar');
            Route::put('member/{id}/email', 'UserController@update_email');
            Route::put('member/{id}/password', 'UserController@update_password');
            Route::get('member.destroy', 'UserController@destroy');


            Route::resource('document', 'DocumentController',
                ['only'=>['show', 'store', 'destroy']]
            );

            Route::post('organization/admin','Organization\UserController@store_admin');
            Route::delete('organization/admin','Organization\UserController@destroy_admin');

            Route::post('organization/team','Organization\Team\TeamController@store');
            Route::put('organization/team','Organization\Team\TeamController@update');
            Route::delete('organization/team','Organization\Team\TeamController@destroy');

            Route::post('organization/team/lead','Organization\Team\UserController@store_lead');
            Route::delete('organization/team/lead','Organization\Team\UserController@destroy_lead');
            Route::post('organization/team/member','Organization\Team\UserController@store_member');
            Route::delete('organization/team/member','Organization\Team\UserController@destroy_member');

            Route::resource('organization', 'Organization\OrganizationController',
                ['except'=>['destroy']]
            );
            Route::resource('team', 'TeamController');
        });


        Route::get('event/{id}/signup', 'EventController@signup');
        Route::get('event/{eid}/download/{fid}', 'EventController@download');
        Route::get('event/calendar', 'EventController@calendar');

        //For rendering the initial views only, no business logic
        Route::resource('event', 'EventController',
            ['only'=>['index', 'create', 'show']]
        );
        Route::resource('member', 'UserController',
            ['only'=>['edit']]
        );

        Route::get('administrator', 'HomeController@administrator');

        Route::resource('organization', 'OrganizationController',
            ['only'=>['index','show','create','edit']]
        );
        Route::resource('team', 'TeamController',
            ['only'=>['index','show', 'edit']]
        );

        Route::get('evite/{id}', 'EviteController@send_evites');
    });
//
// OLD Session stuff
//
    // Route::post('session', 'SessionController@store');
    // Route::get('session', 'SessionController@index');

});
