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
    return ('{"dev name": "vincent utama & kalya icasia"}');
});

/*
RUTE USER CONTROLLER
*/
Route::get('/transaction/user/{CustomerId}','UserController@getUserTransaction'); // cek riwayat transaksi dari id user
Route::get('/user','UserController@all'); // get isi tabel
Route::get('/user/{CustomerId}','UserController@showData'); // get data dari id
Route::post('/user','UserController@store'); // tambah data
Route::post('/verify','UserController@verify'); // verifikasi data
Route::put('/user/{CustomerId}','UserController@update'); //update data
Route::delete('/user/{CustomerId}','UserController@delete'); //delete data

/*
RUTE CART CONTROLLER
*/
Route::get('/cart','CartController@all'); // get isi tabel
Route::get('/cart/{CartId}','CartController@getCartOwner'); // get pemilik cart dari cartid
Route::post('/cart','CartController@store'); // tambah data
Route::get('/cartinfo/{CustomerId}','CartController@obtainCart'); // get cartId & isi cart dari custId
Route::delete('/cart/{CartId}','CartController@delete'); // delete data

/*
RUTE CARTITEM CONTROLLER
*/
Route::get('/cartitem','CartItemController@all'); // get isi tabel
Route::get('/cartitem/{CartItemId}','CartItemController@getCartContent'); // get quantity dan cartid dari cartitemid
Route::post('/cartitem','CartItemController@store'); // tambah data (barbaric)
Route::put('/cartitem','CartItemController@update'); // update data
Route::post('/additem','CartItemController@addItem'); // tambah item dengan sopan dan santun
Route::delete('/cartitem','CartItemController@delete'); // delete data
Route::delete('/delete','CartItemController@deleteall'); // delete data

/*
RUTE ITEM CONTROLLER
*/
Route::get('/item','ItemController@all'); // get isi tabel
Route::get('/item/{ItemId}','ItemController@getItemDetails'); // get detail sebuah item
Route::post('/item','ItemController@store'); // tambah data
Route::put('/item/{ItemId}','ItemController@update'); // update data
Route::delete('/item/{ItemId}','ItemController@delete'); // delete data

/*
RUTE TRANSACTION CONTROLLER
*/
Route::get('/transaction','TransactionController@all'); // get isi tabel
Route::get('/transaction/{TransactionId}','TransactionController@getTransactionDetails'); // get detail transaksi
Route::post('/transaction','TransactionController@store'); // tambah data
Route::delete('/transaction/{ItemId}','TransactionController@delete'); // delete data