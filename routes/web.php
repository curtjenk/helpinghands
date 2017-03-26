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

Route::get('/home', 'HomeController@index');

Route::group(['middleware' => 'auth'], function () {
    Route::get('ticket/calendar', 'TicketController@calendar');
    Route::resource('ticket', 'TicketController');

    Route::get('user/members', 'UserController@members');
    Route::resource('user', 'UserController');
    Route::get('user.destroy', 'UserController@destroy');

    Route::get('administrator', 'HomeController@administrator');

    Route::resource('organization', 'OrganizationController');

    Route::get('evite/{id}', 'EviteController@send_evites');

});
