<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return 'api working';
// });

Route::apiResource("productswithoutlogin","apiProductController");    //need change in online

Route::post("/searchByProductName","apiProductController@searchByProductName");

//categories and subcategories
Route::post("/getsubcategoriesbycategory","apiCategoryController@getSubcategories");

Route:: apiResource("/allcategory","apiCategoryController");

Route::post("/filterByCategoryProduct","apiCategoryController@filterByCategoryProduct");

Route::post('user-login', 'Api\Auth\JwtAuthController@login');
Route::post('user-register', 'Api\Auth\JwtAuthController@register');

Route::apiResource("/checkout","apiOrderController");
//cart
Route:: get("/mostpopularProducts","apiProductController@mostpopularProducts");

Route::post("/searchProductById","apiProductController@searchProductById");

Route::get("/packageproduct","apiProductController@packageproduct");

Route::get("/discountedproduct","apiProductController@discountedproduct");



Route::group(['middleware' => 'jwt.auth'], function () {
    //User Auth
    Route::get('user-logout', 'Api\Auth\JwtAuthController@logout');

	Route::apiResource('/carts','apiCartController');

	Route::post("/getUserCart","apiCartController@getUserCart");

	Route::post("/productwithlogin","apiProductController@productwithlogin");

	Route::apiResource("/user_fav","apifavController");

	Route::post("/likeunlike","apifavController@LikeUnlike");

	Route::post("/updateCart","apiCartController@updateCart");

    // Route::get('user-info', 'Api\Auth\JwtAuthController@getCurrentUser');

    //Products
});

