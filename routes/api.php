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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function () {
    Route::get('evite/s/{tid}/{uid}/{token}', 'EviteController@response_yes');
    Route::get('evite/o/{tid}/{uid}/{token}', 'EviteController@response_no');
});

Route::middleware(['api','auth.basic'])->group(function () {
    Route::get('user/{i}', function (Request $request, $id) {
        $self = Auth::user();
        $user = App\User::findOrFail($id);

        return response()->json($user->memberships()->get());
    });
});