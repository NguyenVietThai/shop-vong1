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

Route::get('/', 'ProductController@index');
Route::get('/product-detail/{id}', 'ProductController@detail');
Route::get('/product-filter', 'ProductController@filter');
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::get('/cart/add', 'CartController@add');
Route::get('/cart/remove', 'CartController@remove');
Route::get('/cart/update', 'CartController@update');
Route::get('/', 'ProductController@index');
Route::get('/product-detail/{id}', 'ProductController@detail');
Route::get('/product-filter', 'ProductController@filter');

Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    });

  Route::prefix('products')->group(function () {
    Route::get('/', 'ProductController@getProductManagerPage')->name('productsManager');
    Route::get('/datatables', 'ProductController@getProductsDatatables')->name('productsDatatables');
    Route::post('/edit/{id}', 'ProductController@editProduct')->name('editProduct');
    Route::get('/api/{id}', 'ProductController@getProductAPI')->name('productDetailAPI');
    Route::post('/create', 'ProductController@createProduct')->name('createProduct');
    Route::get('/{id}', 'ProductController@productDetail')->name('productDetail');
    Route::get('delete/{id}', 'ProductController@deleteManager')->name('deleteProductManager');
  });

  Route::prefix('users')->group(function () {
    Route::get('/', 'UserController@getUsersManager')->name('usersManager');
    Route::get('/datatables', 'UserController@getUsersDatatables')->name('usersDatatables');
    Route::get('delete/{id}', 'UserController@deleteManager')->name('deleteUserManager');
    Route::post('/edit/{id}', 'UserController@editManager')->name('editUserManager');
    Route::get('/api/{id}', 'UserController@getUserAPI')->name('productDetailAPI');
    Route::post('/create', 'UserController@createManager')->name('createUserManager');
    Route::get('/{id}', 'UserController@userDetail')->name('userDetail');
  });
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/test', function () {
  return view('auth.index');
});
