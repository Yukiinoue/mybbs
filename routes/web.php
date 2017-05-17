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
// Top Page
Route::get('/', 'BbsController@index');

// Create
Route::post('/create', 'PostController@create');

// Edit
Route::get('/{id}/edit', 'BbsController@editPage');
Route::patch('/{id}', 'PostController@update');

// Delete
Route::delete('/{id}', 'PostController@delete');

// Reply
Route::get('/{id}/reply', 'BbsController@replyPage');
Route::post('/replyPost', 'PostController@replyPost');