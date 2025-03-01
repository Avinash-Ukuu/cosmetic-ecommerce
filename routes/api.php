<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BlogController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\HomeController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\CouponController;
use App\Http\Controllers\api\ReviewController;
use App\Http\Controllers\api\PaymentController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\LocationController;
use App\Http\Controllers\api\WishlistController;
use App\Http\Controllers\api\ForgotPasswordController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Public route

//Customer register and login
Route::post('/register',                    [AuthController::class, 'register']);
Route::post('/verify-otp',                  [AuthController::class, 'verifyOtp']);
Route::post('/login',                       [AuthController::class, 'login']);

//category
Route::get('category-list',                 [CategoryController::class,'index']);
Route::get('category/{id}',                 [CategoryController::class,'show']);

//Product
Route::get('product-list',                  [ProductController::class,'index']);
Route::get('product/{id}',                  [ProductController::class,'show']);

//Brand
Route::get('brand-list',                    [BrandController::class,'index']);
Route::get('brand/{id}',                    [BrandController::class,'show']);

//Blog
Route::get('blog-list',                     [BlogController::class,'index']);
Route::get('blog/{id}',                     [BlogController::class,'show']);


//Home page data
Route::get('home',                          [HomeController::class,'index']);

Route::get('/countries',                    [LocationController::class, 'getCountries']);
Route::get('/cities/{country_id}',          [LocationController::class, 'getCities']);
Route::get('/shipping-options',             [LocationController::class, 'getShippingOptions']);

// Protected routes
Route::middleware('api.token')->group(function () {
    Route::post('/logout',                  [AuthController::class, 'logout']);
    Route::post('/update-profile',          [AuthController::class, 'updateProfile']);
    Route::post('/store-address',           [AuthController::class, 'storeAddress']);
    Route::post('/update-address',          [AuthController::class, 'updateAddress']);
    Route::get('/get-address',              [AuthController::class, 'getAddress']);
    Route::post('/forgot-password',         [ForgotPasswordController::class, 'sendResetLink']);
    Route::post('/reset-password',          [ForgotPasswordController::class, 'resetPassword']);
    Route::post('/toggle-wishlist',         [WishlistController::class, 'toggleWishlist']);
    Route::get('/wishlist',                 [WishlistController::class, 'getWishlist']);
    Route::post('/add-to-cart',             [CartController::class, 'addToCart']);
    Route::delete('/remove-from-cart',      [CartController::class, 'removeFromCart']);
    Route::get('/get-cart',                 [CartController::class, 'getCart']);
    Route::get('/coupon-list',              [CouponController::class, 'index']);
    Route::post('/submit-review',           [ReviewController::class, 'store']);

    Route::post('/place-order',             [OrderController::class, 'placeOrder']);
    Route::get('/order',                    [OrderController::class, 'getOrder']);

    Route::post('/checkout',                [PaymentController::class, 'createCheckoutSession'])->name('checkout');
});
Route::get('/payment/success/{order}/{token}',      [PaymentController::class, 'success'])->name('payment.success');
Route::get('/payment/cancel/{order}/{token}',       [PaymentController::class, 'cancel'])->name('payment.cancel');
