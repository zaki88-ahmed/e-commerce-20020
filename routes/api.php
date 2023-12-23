<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\BrandController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::post('/user/register',[AuthController::class,'register']);
Route::post('/user/login',[AuthController::class,'login']);
Route::post('/user/logout',[AuthController::class,'logout']);

Route::get('/products/all', [ProductController::class, 'allProducts']);
Route::post('/product/create', [ProductController::class, 'createProduct']);
Route::get('/product/show', [ProductController::class, 'specificProduct']);
Route::post('/product/edit', [ProductController::class, 'updateProduct']);
Route::post('/product/delete', [ProductController::class, 'deleteProduct']);
Route::post('/product/restore', [ProductController::class, 'restoreProduct']);


Route::get('/brands/all', [BrandController::class, 'allBrands']);
Route::post('/brand/create', [BrandController::class, 'createBrand']);
Route::get('/brand/show', [BrandController::class, 'specificBrand']);
Route::post('/brand/edit', [BrandController::class, 'updateBrand']);
Route::post('/brand/delete', [BrandController::class, 'deleteBrand']);
Route::post('/brand/restore', [BrandController::class, 'restoreBrand']);


//Route::post('/stripe/pay', [StripeController::class, 'generateIframeModel']);
Route::post('/stripe/pay', [StripeController::class, 'generateIframeModel']);

Route::post('/invoice/payment/succeeded', [StripeController::class, 'invoicePaymentSucceeded']);
Route::post('/invoice/payment/failed', [StripeController::class, 'invoicePaymentFailed']);
Route::post('/media/delete', [ProductController::class, 'deleteMedia']);

Route::post('cart/add', [CartController::class, 'addToCart']);
Route::post('cart/item/add', [CartController::class, 'addItemToCart']);
Route::get('cart/clear/{user_id}', [CartController::class, 'emptyCart']);
Route::get('cart/clear/{user_id}', [CartController::class, 'removeProductByUserId']);
Route::get('cart/get/{userID}', [CartController::class, 'retriveCart']);
Route::post('cart/increase', [CartController::class, 'increaseQTY']);
//Route::get('cart/get', [CartController::class, 'retriveCart']);



