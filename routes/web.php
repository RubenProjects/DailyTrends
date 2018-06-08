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


Auth::routes();


Route::get('/create-feed',array(

	'as' => 'createFeed',
	'uses' => 'FeedController@createFeed'
));
 
 Route::post('/save-feed',array(

	'as' => 'saveFeed',
	'uses' => 'FeedController@saveFeed'
));


Route::get('/',array(

	'as' => 'home',
	'uses' => 'FeedController@readFeeds'
));


