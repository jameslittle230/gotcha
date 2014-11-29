<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(['before' => 'auth'], function(){
	Route::get('/', ['as' => 'game', 'uses' => 'GameController@index']);
	Route::post('tag', ['as' => 'tag', 'uses' => 'GameController@tag']);

	Route::get('logout', ['as' => 'logout', 'uses' => 'SessionController@delete']);
});

Route::group(['before' => 'guest'], function(){
	Route::get('login', ['as' => 'login', 'uses' => 'SessionController@create']);
	Route::post('login', ['as' => 'login', 'uses' => 'SessionController@store']);
});

Route::get('rules', ['as' => 'rules', 'uses' => 'PagesController@rules']);
Route::get('about', ['as' => 'about', 'uses' => 'PagesController@about']);
Route::get('stats', ['as' => 'stats', 'uses' => 'PagesController@stats']);

Route::get('create', ['as' => 'create', 'uses' => 'TestingController@create', 'before' => 'super_auth']);
Route::get('seeAll', ['as' => 'seeAll', 'uses' => 'TestingController@seeAll', 'before' => 'super_auth']);
Route::get('download', ['as' => 'download', 'uses' => 'PagesController@download_db', 'before' => 'super_auth']);
Route::post('player/update/{id}', ['as' => 'player.update', 'uses' => 'TestingController@updateUser', 'before' => 'csrf']);

Route::get('teacher-ban', ['as' => 'permaban', 'uses' => 'PermabanController@show']);
Route::get('teacher-ban/login', ['as' => 'permaban_login', 'uses' => 'PermabanController@create']);
Route::post('teacher-ban/login', ['as' => 'permaban_login', 'uses' => 'PermabanController@store']);
Route::post('teacher-ban/go', ['as' => 'permaban_go', 'uses' => 'PermabanController@go']);
