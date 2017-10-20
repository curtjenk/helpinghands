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
    Route::get('/home', 'HomeController@index');
    Route::get('/db', 'DashboardController@index');

    Route::get('event/{id}/members', 'EventController@members');
    Route::get('event/{id}/signup', 'EventController@signup');
    Route::get('event/{eid}/download/{fid}', 'EventController@download');
    Route::get('event/calendar', 'EventController@calendar');
    Route::post('event/notify/{id}', 'EventController@notify');
    Route::resource('event', 'EventController');

    Route::get('member', 'UserController@members');
    Route::get('member/{id}', 'UserController@yes_responses');
    Route::post('member/{id}/proxySignup', 'UserController@proxy_signup');
    Route::get('member/signups/{eventid}', 'UserController@signups');
    Route::post('member/eventpay/{eventid}', 'UserController@pay');
    Route::resource('member', 'UserController');
    Route::post('member/{id}/avatar', 'UserController@avatar');
    Route::put('member/{id}/email', 'UserController@update_email');
    Route::get('member.destroy', 'UserController@destroy');

    Route::get('administrator', 'HomeController@administrator');

    Route::resource('organization', 'OrganizationController');

    Route::get('evite/{id}', 'EviteController@send_evites');
//
// Session stuff
//
    Route::post('session', 'SessionController@store');
    Route::get('session', 'SessionController@index');

});
