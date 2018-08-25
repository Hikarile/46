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

Route::get('/train-lookup/{date}/{from}/{to}/{type}', ['as'=>'train-lookup', 'uses'=>'TrainController@trainLookup']);
Route::get('/train-info/{code}', ['as'=>'train-info.search', 'uses'=>'TrainController@trainInfoSearch']);
Route::get('/train-info', ['as'=>'train-info', 'uses'=>'TrainController@trainInfo']);
Route::post('/order/do', ['as'=>'order.do', 'uses'=>'OrderController@orderDo']);
Route::get('/order/cancel/{id}', ['as'=>'order.cancel', 'uses'=>'OrderController@orderCancel']);
Route::get('/order/{code?}/{date?}/{from?}/{to?}', ['as'=>'order', 'uses'=>'OrderController@order']);
Route::get('/order-done/{id}', ['as'=>'order-done', 'uses'=>'OrderController@orderDone']);
Route::get('/order-log/search', ['as'=>'order-log.search', 'uses'=>'OrderController@orderLogSearch']);
Route::get('/order-log', ['as'=>'order-log', 'uses'=>'OrderController@orderLog']);

Route::group(['prefix'=>'manage', 'middleware'=>'auth'],function(){
	Route::post('/type/insert/do', ['as'=>'manage.type.insert.do', 'uses'=>'ManageController@typeInsertDo']);
	Route::get('/type/insert', ['as'=>'manage.type.insert', 'uses'=>'ManageController@typeInsert']);
	Route::post('/type/update/do', ['as'=>'manage.type.update.do', 'uses'=>'ManageController@typeUpdateDo']);
	Route::get('/type/update/{id}', ['as'=>'manage.type.update', 'uses'=>'ManageController@typeUpdate']);
	Route::get('/type/delete/{id}', ['as'=>'manage.type.delete', 'uses'=>'ManageController@typeDelete']);
	Route::get('/type', ['as'=>'manage.type', 'uses'=>'ManageController@type']);

	Route::post('/train/insert/do', ['as'=>'manage.train.insert.do', 'uses'=>'ManageController@trainInsertDo']);
	Route::get('/train/insert', ['as'=>'manage.train.insert', 'uses'=>'ManageController@trainInsert']);
	Route::post('/train/update/do', ['as'=>'manage.train.update.do', 'uses'=>'ManageController@trainUpdateDo']);
	Route::get('/train/update/{code}', ['as'=>'manage.train.update', 'uses'=>'ManageController@trainUpdate']);
	Route::get('/train/delete/{code}', ['as'=>'manage.train.delete', 'uses'=>'ManageController@trainDelete']);
	Route::get('/train', ['as'=>'manage.train', 'uses'=>'ManageController@train']);
	
	Route::get('/order/search', ['as'=>'manage.order.search', 'uses'=>'ManageController@orderSearch']);
	Route::get('/order', ['as'=>'manage.order', 'uses'=>'ManageController@order']);
});
Route::auth();

Route::get('/', 'HomeController@index');
