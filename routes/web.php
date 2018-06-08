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


Route::get('/delete-feed/{feed_id}', array(
	'as' =>'deleteFeed',
	'uses'=>'FeedController@deleteFeed'
));

Route::get('/edit/{feed_id}',array(

	'as' => 'editFeed',
	'uses' => 'FeedController@editFeed'
));

Route::post('/update-feed/{feed_id}',array(

	'as' => 'updateFeed',
	'uses' => 'FeedController@updateFeed'
));

