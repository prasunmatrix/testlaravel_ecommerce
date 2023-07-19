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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('index',['page_title' => 'Ecommerce']);
// });

Route::get('/',[
	'as' 	=>'homepage',
	'uses' 	=>'HomeController@home' 
]);

Route::get('admin', [
	'as'	=> 'login.form.admin',
	'uses'	=> 'AdminController@getAdminLogin',
]);
Route::post('admin', [
	'as'	=> 'login.admin',
	'uses'	=> 'AdminController@postAdminLogin',
]);

Route::get('admin-dashboard', [
	'as'	=> 'dashboard.admin',
	'uses'	=> 'AdminController@getAdminDashboard',
]);

Route::get('logout', [
'as'=>'logout',
'uses'=>'AdminController@logOut' 
]);

Route::get('add-category', [
'as'=>'add.form.category',
'uses'=>'AdminController@addCategory' 
]);

Route::post('add-category', [
'as'=>'add.category',
'uses'=>'AdminController@postAddCategory' 
]);
Route::get('get_category_slug',[
	'as'	=>'get.category_slug',
	'uses'=>'AdminController@getCategorySlug'
]);
Route::get('view-category',[
	'as'   => 'view.category',
	'uses' => 'AdminController@getAllCategory',
]);
Route::get('edit-category/{category_id}',[
	'as'   => 'edit.category',
	'uses' => 'AdminController@getEditFromCategory',
]);
Route::post('edit-category/{category_id}', [
	'as'   => 'edit.update.category',
	'uses' => 'AdminController@postEditFormCategory',
]);
Route::get('change-status-category/{category_id}/{status_code}',[
	'as'   => 'change.status.category',
	'uses' => 'AdminController@getChangeStatusCategory',
]);
Route::get('delete-category/{category_id}',[
	'as'   => 'delete.category',
	'uses' => 'AdminController@getDeleteCategory',
]);
Route::get('view-product',[
	'as'   => 'view.product',
	'uses' => 'AdminController@getAllProduct',
]);
Route::get('add-product',[
	'as'	=>'add.form.product',
	'uses'=>'AdminController@addProduct'
]);
Route::post('add-product',[
	'as'	=>'add.product',
	'uses'=>'AdminController@postAddProduct'
]);
Route::get('product_get_details',[
	'as'	=>'product.get_details',
	'uses'=>'AdminController@productGetDetails'
]);
Route::get('product_get_sku',[
	'as'	=>'product.get_sku',
	'uses'=>'AdminController@productGetSku'
]);
Route::get('update_popular',[
	'as'	=>'product.update_popular',
	'uses'=>'AdminController@productUpdatePopular'
]);
Route::get('change-status-product/{product_id}/{status_code}',[
	'as'   => 'change.status.product',
	'uses' => 'AdminController@getChangeStatusProduct',
]);
Route::get('delete-product/{product_id}',[
	'as'   => 'delete.product',
	'uses' => 'AdminController@getDeleteProduct',
]);
Route::get('edit-product/{product_id}',[
	'as'   => 'edit.product',
	'uses' => 'AdminController@getEditFromProduct'
]);
Route::post('edit-product/{product_id}', [
	'as'   => 'edit.update.product',
	'uses' => 'AdminController@postEditFormProduct',
]);
//Auth::routes();
//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', [
	'as' =>'home',
	'uses'=>'HomeController@index',
]);
Route::get('add_to_cart', [
	'as' =>'get.add_to_cart',
	'uses'=>'HomeController@addToCart',
]);
Route::get('cart', [
	'as' =>'get.cart',
	'uses'=>'HomeController@cart',
]);
Route::get('update_cart', [
	'as' =>'get.update_cart',
	'uses'=>'HomeController@updateCart',
]);
Route::get('delete_product', [
	'as' =>'get.delete_product',
	'uses'=>'HomeController@deleteProduct',
]);