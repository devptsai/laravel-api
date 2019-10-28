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

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::group(['middleware' => 'auth:api'], function(){ 
    Route::post('details', 'API\UserController@details');
    Route::get('siswa','SiswaController@index');
    Route::post('siswa','SiswaController@create');
    Route::get('/siswa/{id}','SiswaController@show');
    Route::put('/siswa/{id}','SiswaController@update');
    Route::delete('/siswa/{id}','SiswaController@destroy');
});



// Route::middleware('auth:api')->get('/siswa', 'SiswaController@index');
// Route::middleware('auth:api')->post('/siswa', 'SiswaController@create');
// Route::middleware('auth:api')->put('/siswa/{id}', 'SiswaController@update');
// Route::middleware('auth:api')->delete('/siswa/{id}', 'SiswaController@destroy');

