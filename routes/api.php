<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api'], function () {
    Route::group(['namespace'=>'Api'], function () {
        Route::get('evite/s/{tid}/{uid}/{token}', 'EviteController@response_yes');
        Route::get('evite/o/{tid}/{uid}/{token}', 'EviteController@response_no');
    });
});

Route::group(['middleware' => 'api'], function () {
    Route::group(['namespace'=>'Grilloff'], function () {
        Route::post('judge/vote', 'JudgeController@vote');
        Route::get('judge/results', 'JudgeController@results');
        Route::delete('judge/results', 'JudgeController@results_delete');
        Route::resource('contestant', 'ContestantController');
        Route::resource('judge', 'JudgeController');
        Route::resource('user', 'UserController');
    });
});
// Route::middleware(['api','auth.basic'])->group(function () {
//     Route::get('user/{i}', function (Request $request, $id) {
//         $self = Auth::user();
//         $user = App\User::findOrFail($id);
//
//         return response()->json($user->memberships()->get());
//     });
// });