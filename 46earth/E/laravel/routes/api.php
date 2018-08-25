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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// Route::get('books/reset',['as'=>'reset','uses'=>'BookController@reset']);//清空

// Route::post('books',['as'=>'books','uses'=>'BookController@books']);//新增

// Route::get('books/{id?}',['as'=>'inquire','uses'=>'BookController@inquire']);//查詢

// Route::put('books/{id?}',['as'=>'fix','uses'=>'BookController@fix']);//修改

// Route::delete('books/{id?}',['as'=>'d','uses'=>'BookController@d']);//刪除

// Route::get('books',['as'=>'all','uses'=>'BookController@all']);//查詢全部

// Route::get('books/{text?}',['as'=>'notfoud','uses'=>'BookController@notfoud']);//不存在的路徑


//Route::resource('books','BooksController');
