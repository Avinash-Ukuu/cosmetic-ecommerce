<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cms\BlogController;
use App\Http\Controllers\cms\RoleController;
use App\Http\Controllers\cms\UserController;
use App\Http\Controllers\cms\BrandController;
use App\Http\Controllers\cms\OrderController;
use App\Http\Controllers\cms\CommonController;
use App\Http\Controllers\cms\ModuleController;
use App\Http\Controllers\cms\ProductController;
use App\Http\Controllers\cms\CategoryController;
use App\Http\Controllers\cms\CustomerController;
use App\Http\Controllers\cms\DashboardController;
use App\Http\Controllers\cms\PermissionController;
use App\Http\Controllers\cms\ActivityLogsController;
use App\Http\Controllers\cms\CouponController;

//dashboard
Route::get('/dashboard',                    [DashboardController::class,'dashboard'])->name('dashboard');

//user management
Route::resource('user',                     UserController::class);
Route::resource('role',                     RoleController::class);
Route::resource('permission',               PermissionController::class);
Route::resource('module',                   ModuleController::class);
Route::get("assign/user/roles/{id}",        [UserController::class,'assignRoleForm'])->name('assignRoles');
Route::post("submit/user/roles",            [UserController::class,'assignRole'])->name('submitRole');
Route::get("assign/role/permissions/{id}",  [RoleController::class,'assignPermissionForm'])->name('assignPermissions');
Route::post("submit/role/permissions",      [RoleController::class,'assignPermission'])->name('submitPermission');
Route::get("/change/password",              [UserController::class,'changePassword'])->name("changePassword");
Route::post("/update/password",             [UserController::class,'updatePassword'])->name("updatePassword");
Route::get("switch/user/form",              [UserController::class,'switchUserForm'])->name('switchUserForm');
Route::post("switch/user",                  [UserController::class,'switchUser'])->name('switchUser');
Route::get("logout/switch/user",            [UserController::class,'logoutSwitchUser'])->name('logoutSwitchUser');
Route::get('profile/{id}',                  [UserController::class,'profile'])->name('userProfile');
Route::put('store-profile,{id}',            [UserController::class,'storeProfile'])->name('storeProfile');

Route::get("activity/logs",                 [ActivityLogsController::class,'index'])->name("activityLogs");

//Category
Route::resource('category',                 CategoryController::class);
Route::get('show-category-data',            [CategoryController::class,'showCategories']);

//Sub Category
// Route::resource('sub-category',             SubCategoryController::class);

//Brand
Route::resource('brand',                    BrandController::class);

// Blog
Route::resource('blog',                     BlogController::class);

//Product
Route::resource('product',                  ProductController::class);
Route::get('low-product',                   [ProductController::class,'lowProduct'])->name('lowProduct');

//Customer
Route::resource('customer',                 CustomerController::class);


//Order
Route::resource('order',                    OrderController::class);
Route::post('order-item/update-status/{id}',[OrderController::class,'updateOrderItemStatus'])->name('updateOrderItemStatus');


//Coupon
Route::resource('coupon',                   CouponController::class);

//Common routes

Route::post('/sort/rows',                   [CommonController::class,'sortRows'])->name('sortRows');
Route::post('/is/restricted',               [CommonController::class,'isRestricted'])->name('isRestricted');
Route::post('/is/public',                   [CommonController::class,'isActiveAction'])->name('isActiveAction');
Route::post('/product/image/delete',        [CommonController::class,'productImageDelete'])->name('productImageDelete');
Route::post('/is/publish',                  [CommonController::class,'isPublishAction'])->name('isPublishAction');
