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

Route::post('login', 'UserController@login');
Route::post('logout', 'UserController@logout');
Route::post('register', 'UserController@register');

Route::group(['middleware' => 'jwt.auth'],function(){  
	//tus rutas 
	Route::get('/users', function() {
		return response()->json('aquí irán los usuarios.');
	});
});
