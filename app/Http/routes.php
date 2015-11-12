<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return redirect('/index');
});

Route::get('/index', ['middleware' => 'auth', function () {
	return view('domain.search');
}]);

Route::get('/admin', ['middleware' => 'auth', function () {
	return view('admin.admin');
}]);

// Authentication routes...
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

// Domain routes...
Route::post('domain/search', 'DomainController@search');
Route::post('domain/create', 'DomainController@create');
