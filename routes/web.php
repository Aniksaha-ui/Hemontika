<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});

Route::get('/checkout', function () {
    return view('exampleEasyCheckout');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//All route for admin

Route::get('admin/home','AdminController@index');
Route::get('/admin','Admin\LoginController@showLoginForm')->name('admin.login');
Route::post('/admin','Admin\LoginController@login');
Route::get('admin/logout','AdminController@Logout')->name('admin.logout');


//All route for category
Route::get('/catagory','Admin\Category\CategoryController@category')->name('category');
Route::post('/admin/store/category','Admin\Category\CategoryController@storecategory')->name('store.category');
Route::get('delete/category/{id}','Admin\Category\CategoryController@Deletecategory');
Route::get('edit/category/{id}','Admin\Category\CategoryController@Editcategory');
Route::post('update/category/{id}','Admin\Category\CategoryController@Updatecategory');


//Brands
Route::get('admin/brand','Admin\Category\BrandController@Brand')->name('brands');
Route::post('/admin/store/brand','Admin\Category\BrandController@storeBrand')->name('store.brand');
Route::get('delete/brand/{id}','Admin\Category\BrandController@DeleteBrand');	
Route::get('edit/brand/{id}','Admin\Category\BrandController@EditBrand');
Route::post('update/brand/{id}','Admin\Category\BrandController@UpdateBrand');



//subcategory

Route::get('admin/sub/catagory','Admin\Category\SubCategoryController@SubCategories')->name('sub.category');
Route::post('/admin/store/subcat','Admin\Category\SubCategoryController@StoreSubCat')->name('store.subcategory');
Route::get('delete/subcategory/{id}','Admin\Category\SubCategoryController@DeleteSubCat');	
Route::get('edit/subcategory/{id}','Admin\Category\SubCategoryController@EditSubCat');
Route::post('update/subcategory/{id}','Admin\Category\SubCategoryController@UpdateSubCat');


//Product 
Route::get('get/subcategory/{category_id}', 'ProductController@GetSubcat');
Route::get('admin/product/all','ProductController@index')->name('all.product');
Route::get('admin/product/add','ProductController@create')->name('add.product');
Route::post('admin/store/product', 'ProductController@store')->name('store.product');
Route::get('inactive/product/{id}', 'ProductController@inactive');
Route::get('active/product/{id}', 'ProductController@active');
Route::get('delete/product/{id}', 'ProductController@DeleteProduct');
Route::get('view/product/{id}', 'ProductController@ViewProduct');
Route::get('edit/product/{id}', 'ProductController@EditProduct');



//ssl
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);