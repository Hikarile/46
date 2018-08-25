<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('books/reset',['as'=>'reset','uses'=>'BookController@reset']);//清空

Route::post('books',['as'=>'books','uses'=>'BookController@books']);//新增

Route::get('books/{id?}',['as'=>'inquire','uses'=>'BookController@inquire']);//查詢,全部顯示,不存在的路徑

Route::PUT('books/{id?}',['as'=>'fix','uses'=>'BookController@fix']);//修改

Route::delete('books/{id?}',['as'=>'d','uses'=>'BookController@d']);//刪除