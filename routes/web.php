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

// cron routes
Route::get('/cron_update', 'SoapController@update')->name('cron_update');;

// main routes
Route::post('/cart/order/complete', 'CartController@complete')->name('order_complete');;

Route::post('/cart/order', 'CartController@order')->name('cart_order');;

Route::get('/cart', 'CartController@index')->name('cart');;

Route::post('/cart/add', 'CartController@add')->name('cart_add');;

Route::post('/cart/del', 'CartController@del')->name('cart_del');;

Route::get('/catalog', 'CatalogController@index')->name('catalog');;

Route::get('/catalog/search', 'CatalogController@search')->name('catalog_search');;  // disable in robots.txt

Route::get('/collection/{collection_slug}.html', 'CatalogController@index')->name('collection_detail');;

Route::get('/style/{style_slug}.html', 'CatalogController@index')->name('style_detail');;

Route::get('/catalog/{category}/{item}', 'CatalogController@detail')->name('catalog_category');;

Route::get('/collections', 'CollectionController@index')->name('collections');;

Route::get('/styles', 'StyleController@index')->name('styles');;

Route::post('/contacts/send', 'MainController@contact')->name('contacts_send');;

Route::get('/', 'MainController@index')->name('index');;

// backpack admin
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin'], 'namespace' => 'Admin'], function () {

    // Backpack\MenuCRUD
    CRUD::resource('menu-item', 'MenuItemCrudController');

    // Backpack\NewsCRUD (Refactored)
    CRUD::resource('article', 'ArticleCrudController');
    CRUD::resource('article-category', 'ArticleCategoryCrudController');

    //Products CRUD (Category, Brand, Product)
    CRUD::resource('product-category', 'CategoryCrudController');
    CRUD::resource('product-tag', 'TagCrudController');
    CRUD::resource('product-item', 'ProductCrudController');
    CRUD::resource('product-brand', 'BrandCrudController');
    CRUD::resource('product-family', 'FamilyCrudController');
    CRUD::resource('product-style', 'StyleCrudController');
    CRUD::resource('product-collection', 'CollectionCrudController');

    CRUD::resource('banner', 'BannerCrudController');
});

/** CATCH-ALL ROUTE for Backpack/PageManager - needs to be at the end of your routes.php file  **/
Route::get('{page}/{subs?}', ['uses' => 'PageController@index'])
    ->where(['page' => '^((?!admin).)*$', 'subs' => '.*']);
