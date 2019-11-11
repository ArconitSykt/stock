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

Route::get('/', function () {
    return view('index');
});
// =============================================================================
//  ITEMS
// =============================================================================
Route::get('items', [
    'uses' => 'ItemsController@index',
]);

Route::get('items/user/{id}', [
    'uses' => 'ItemsController@getUserItems',
]);

Route::get('items/{id}', [
    'uses' => 'ItemsController@get',
]);
Route::get('hystory/{id}', [
    'uses' => 'ItemsController@getHystoryItem',
]);

Route::post('update/item/', [
    'uses' => 'ItemsController@update',
]);

Route::post('create/item/', [
    'uses' => 'ItemsController@create',
]);

Route::post('delete/item/', [
    'uses' => 'ItemsController@delete',
]);
// =============================================================================
// Users
// =============================================================================
Route::get('users', [
    'uses' => 'UsersController@index',
]);
Route::get('raw/users/', [
    'uses' => 'UsersController@raw',
]);

Route::get('users/{id}', [
    'uses' => 'UsersController@get',
]);

Route::post('update/user/', [
    'uses' => 'UsersController@update',
]);

Route::post('create/user/', [
    'uses' => 'UsersController@create',
]);

Route::post('delete/user/', [
    'uses' => 'UsersController@delete',
]);
// =============================================================================
// LIST
// =============================================================================
Route::get('list/{name}', [
    'uses' => 'ListsController@get',
]);
// =============================================================================
// BARCODE
// =============================================================================
Route::get('barcode/{id}', [
    'uses' => 'BarcodeController@show',
]);
Route::post('barcode_pull', [
    'uses' => 'BarcodeController@show_pull',
]);
Route::get('material_card/{id}', [
    'uses' => 'UsersController@materialCard',
]);
Route::post('trans_report', [
    'uses' => 'DocPackController@DocPack',
]);
// =============================================================================
// Agreements
// =============================================================================

Route::post('agreements/add', [
    'uses' => 'AgreementsController@store',
]);

Route::get('agr', [
    'uses' => 'AgreementsController@index',
]);

Route::post('agreements/search', [
    'uses' => 'AgreementsController@search',
]);