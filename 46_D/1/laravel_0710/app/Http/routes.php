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

Route::get('/', function(){ return view('train.index'); });

Route::get('/train-lookup/{date}/{form}/{to}/{type}', ['uses'=>'TrainController@TrainSearch']);

Route::post('/order/do', ['as'=>'order_do', 'uses'=>'OrderController@OrderDo']);
Route::get('/order/cancel/{id}', ['as'=>'order_cancel', 'uses'=>'OrderController@OrderCancel']);
Route::get('/order/validate', ['uses'=>'OrderController@OrderValidate']);
Route::get('/order/{code?}/{from?}/{to?}/{date?}', ['as'=>'order', 'uses'=>'OrderController@Order']);

Route::get('/order-log', function(){ return view('train.order-log'); });
Route::get('/order-log/do', ['as'=>'order-log_do', 'uses'=>'OrderController@OrderLogDo']);

Route::get('/train-info', function(){ return view('train.train-info'); });
Route::get('/train-info/{code}', ['as'=>'train-info_search','uses'=>'TrainController@SearchTrainInfo']);

Route::get('/manage/type', ['as'=>'type_select', 'uses'=>'ManageController@SelectType']);
Route::get('/manage/type/insert', ['as'=>'type_insert', 'uses'=>'ManageController@InsertType']);
Route::get('/manage/type/insert/do/{name}/{speed}', ['as'=>'type_insert_do', 'uses'=>'ManageController@InsertTypeDo']);
Route::get('/manage/type/delete/{id}', ['as'=>'type_delete', 'uses'=>'ManageController@DeleteType']);
Route::get('/manage/type/update/{id}', ['as'=>'type_update', 'uses'=>'ManageController@UpdateType']);
Route::get('/manage/type/update/do/{id}/{name}/{speed}', ['as'=>'type_update_do', 'uses'=>'ManageController@UpdateTypeDo']);

Route::get('/manage/train', ['as'=>'train_select', 'uses'=>'ManageController@SelectTrain']);
Route::get('/manage/train/insert', ['as'=>'train_insert', 'uses'=>'ManageController@InsertTrain']);
Route::get('/manage/train/insert/do', ['as'=>'train_insert_do', 'uses'=>'ManageController@InsertTrainDo']);
Route::get('/manage/train/update/do', ['as'=>'train_update_do', 'uses'=>'ManageController@UpdateTrainDo']);
Route::get('/manage/train/update/{code}', ['as'=>'train_update', 'uses'=>'ManageController@UpdateTrain'])->where('code','^\d+$');
Route::get('/manage/train/delete/{code}', ['as'=>'train_delete', 'uses'=>'ManageController@DeleteTrain']);

Route::get('/manage/order', function(){ return view('train.manage.order'); });
Route::get('/manage/order/search', ['as'=>'manage_order_search', 'uses'=>'ManageController@SearchOrder']);

Route::auth();

Route::get('/home', 'HomeController@index');
