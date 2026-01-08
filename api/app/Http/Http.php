<?php

use Core\Routes\Route;
use Core\Middleware\AuthToken;
use Core\Middleware\AuthSession;

// route login
Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');

Route::get('verify', 'AuthController@verify');
Route::get('profile/{img}', 'AuthController@profile', [new AuthSession("user")]);

// toke controller for qbo
Route::get('token', 'QBOServiceController@token', [new AuthSession("user")]);
Route::get('token/generate', 'QBOServiceController@generate', [new AuthSession("user")]);

// customers
Route::group(['prefix' => 'customers', 'middleware' => [new AuthSession("user")]], function () {
    Route::get('list', 'CustomersController@index');
    Route::post('add', 'CustomersController@add');
    Route::post('update', 'CustomersController@update');
    Route::post('delete', 'CustomersController@delete');
    Route::get('contacts', 'CustomersController@contacts');
    Route::post('contacts', 'CustomersController@save_contacts');
});

// cylinders
Route::group(['prefix' => 'cylinders', 'middleware' => [new AuthSession("user")]], function () {
    Route::get('list', 'CylindersController@index');
    Route::post('add', 'CylindersController@add');
    Route::post('update', 'CylindersController@update');
    Route::post('delete', 'CylindersController@delete');
});


// locations
Route::group(['prefix' => 'locations', 'middleware' => [new AuthSession("user")]], function () {
    Route::get('list', 'LocationsController@index');
    Route::post('add', 'LocationsController@add');
    Route::post('update', 'LocationsController@update');
    Route::post('delete', 'LocationsController@delete');
});
// categories
Route::group(['prefix' => 'categories', 'middleware' => [new AuthSession("user")]], function () {
    Route::get('list', 'CategoriesController@index');
    Route::post('add', 'CategoriesController@add');
    Route::post('update', 'CategoriesController@update');
    Route::post('delete', 'CategoriesController@delete');
});
// types
Route::group(['prefix' => 'types', 'middleware' => [new AuthSession("user")]], function () {
    Route::get('list', 'TypesController@index');
    Route::post('add', 'TypesController@add');
    Route::post('update', 'TypesController@update');
    Route::post('delete', 'TypesController@delete');
});
// units
Route::group(['prefix' => 'units', 'middleware' => [new AuthSession("user")]], function () {
    Route::get('list', 'UnitsController@index');
    Route::post('add', 'UnitsController@add');
    Route::post('update', 'UnitsController@update');
    Route::post('delete', 'UnitsController@delete');
});




// gmmr nonpharmacy
Route::group(['prefix' => 'nonpharmacy', 'middleware' => [new AuthSession("user")]], function () {
    // gmmr functions
    Route::get('invoices', 'NonPharmaController@index');
    Route::get('edit', 'NonPharmaController@edit');
    Route::get('details', 'NonPharmaController@details');
    Route::post('update', 'NonPharmaController@update');

    // for quickbooks functions
    Route::post('book_invoice', 'NonPharmaController@book_invoice');
    Route::post('update_invoice', 'NonPharmaController@update_invoice');
    Route::post('edit_invoice', 'NonPharmaController@edit_invoice');
    Route::post('delete_invoice', 'NonPharmaController@delete_invoice');
    Route::post('findInvoice', 'NonPharmaController@findInvoice');
});




// Route::get('users/{id}', 'AppController@edit', [new AuthToken()]);
Route::get('users/id/{id}/date/{date}', 'AppController@showByIdDate', [new AuthToken()]);

Route::post('index', 'AppController@index', [new AuthToken()]);
Route::get('index', 'AppController@index', [new AuthSession("user")]);
Route::post('index', 'AppController@index', [new AuthSession("user")]);


// Group with prefix
Route::group(['prefix' => 'api/inventory', 'middleware' => [new AuthToken()]], function () {
    Route::get('items', 'InventoryController@index');
    Route::get('items/{id}', 'InventoryController@show');
    Route::post('items', 'InventoryController@store');
});
