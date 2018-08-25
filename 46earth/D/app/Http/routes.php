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

Route::get('index',['as'=>'index','uses'=>'TrainsController@index']);
Route::get('look/{from1?}/{to?}/{type?}/{date?}',['as'=>'look','uses'=>'TrainsController@look']);

Route::get('order/{number?}/{date?}/{from?}/{to?}',['as'=>'order','uses'=>'TrainsController@order']);
Route::post('order/save',['as'=>'ordersave','uses'=>'TrainsController@order_save']);
Route::get('order_done/{id?}',['as'=>'order_done','uses'=>'TrainsController@order_done']);

Route::get('order_log/{sn?}/{phone?}',['as'=>'order_log','uses'=>'TrainsController@order_log']);
Route::get('order_log_d/{id?}',['as'=>'order_log_d','uses'=>'TrainsController@order_log_d']);

Route::get('train_info/{number?}',['as'=>'train_info','uses'=>'TrainsController@train_info']);

Route::get('png',['as'=>'png','uses'=>'TrainsController@png']);
Route::get('img/{date?}/{type?}',['as'=>'img','uses'=>'TrainsController@img']);
Route::get('json/{date?}/{type?}',['as'=>'json','uses'=>'TrainsController@json']);

Route::get('login/{type?}',['as'=>'login','uses'=>'TrainsController@login']);
Route::post('dnlu',['as'=>'dnlu','uses'=>'TrainsController@dnlu']);
Route::get('out',['as'=>'out','uses'=>'TrainsController@out']);

Route::get('type',['as'=>'type','uses'=>'TrainsController@type']);
Route::get('typeadd',['as'=>'typeadd','uses'=>'TrainsController@typeadd']);
Route::get('typef/{id?}',['as'=>'typef','uses'=>'TrainsController@typef']);
Route::post('typesave',['as'=>'typesave','uses'=>'TrainsController@typesave']);

Route::get('train',['as'=>'train','uses'=>'TrainsController@train']);
Route::get('trainadd',['as'=>'trainadd','uses'=>'TrainsController@trainadd']);
Route::get('trainf/{id?}',['as'=>'trainf','uses'=>'TrainsController@trainf']);
Route::post('trainsave',['as'=>'trainsave','uses'=>'TrainsController@trainsave']);
Route::get('traind/{id?}',['as'=>'traind','uses'=>'TrainsController@traind']);

Route::get('ticket/{date?}/{number?}/{phone?}/{from?}/{to?}',['as'=>'ticket','uses'=>'TrainsController@ticket']);
Route::get('ticketd/{id?}',['as'=>'ticketd','uses'=>'TrainsController@ticketd']);

Route::get('d/{type?}/{id?}',['as'=>'d','uses'=>'TrainsController@d']);