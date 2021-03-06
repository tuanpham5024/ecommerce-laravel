<?php

use App\Http\Controllers\Client\CommentsController;
use App\Http\Controllers\Client\CustomersController;
use App\Http\Controllers\Client\SendMailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductsController as ProductsClient;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\OrdersController;
use App\Http\Controllers\Admin\CommentsController as CommentsControllerAdmin;
use App\Http\Controllers\Admin\OrdersController as OrdersControllerAdmin;

require __DIR__ . '/customer.php';

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

/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('dashboard/login', [LoginController::class, 'getLogin'])->name('login');
Route::post('dashboard/login/store', [LoginController::class, 'postLogin']);
Route::get('dashboard/logout', [LoginController::class, 'getLogout'])->name('logout');


Route::middleware('auth')->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        # Categories
        Route::prefix('categories')->group(function () {
            Route::get('/', [CategoriesController::class, 'index'])->name('dashboard.categories');
            Route::get('edit/{category}', [CategoriesController::class, 'show']);
            Route::post('edit/{category}', [CategoriesController::class, 'update']);
            Route::get('add', [CategoriesController::class, 'create']);
            Route::post('store', [CategoriesController::class, 'store']);
            Route::delete('destroy', [CategoriesController::class, 'destroy'])->name('dashboard.destroy');
        });

        # Products
        Route::prefix('products')->group(function () {
            Route::get('/', [ProductsController::class, 'index'])->name('dashboard.products');
            Route::get('add', [ProductsController::class, 'create']);
            Route::post('store', [ProductsController::class, 'store']);
            Route::get('edit/{product}', [ProductsController::class, 'show']);
            Route::post('edit/{product}', [ProductsController::class, 'update']);
            Route::delete('destroy', [ProductsController::class, 'destroy'])->name('product.destroy');
        });

        # Comment
        Route::prefix('comments')->group(function () {
            Route::get('/', [CommentsControllerAdmin::class, 'index'])->name('dashboard.comments');
            Route::post('status', [CommentsControllerAdmin::class, 'status'])->name('dashboard.status');
            Route::post('destroy', [CommentsControllerAdmin::class, 'destroy'])->name('dashboard.destroy');
        });


        # Orders
        Route::prefix('orders')->group(function() {
            Route::get('/', [OrdersControllerAdmin::class, 'index'])->name('dashboard.orders');
            Route::delete('destroy', [OrdersControllerAdmin::class, 'destroy']);
            Route::get('edit/{order}', [OrdersControllerAdmin::class, 'show']);
            Route::post('edit/status', [OrdersControllerAdmin::class, 'status'])->name('dashboard.orders.status');
            Route::post('edit/inforuser', [OrdersControllerAdmin::class, 'inforuser'])->name('dashboard.orders.inforuser');
            Route::post('edit/remove-item', [OrdersControllerAdmin::class, 'remove'])->name('dashboard.orders.remove');
            Route::post('edit/add-item', [OrdersControllerAdmin::class, 'add'])->name('dashboard.orders.add');
        });

        # Upload
        Route::post('upload/services', [UploadController::class, 'store']);
    });
});


/*
|--------------------------------------------------------------------------
| CLIENT
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'home'])->name('home');

Route::prefix('products')->group(function () {
    Route::get('/', [ProductsClient::class, 'index'])->name('products');
    Route::get('{slug}', [ProductsClient::class, 'show']);
    Route::get('add-to-cart/{id}', [CartController::class, 'add'])->name('addToCart');
    Route::get('delete-one-item/{id}', [CartController::class, 'delete'])->name('deleteOneItem');
});



// Checkout
Route::prefix('checkout')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('cart');
    Route::delete('cart/destroy/{id}', [CartController::class, 'destroy'])->name('deleteItemCart');

    Route::get('payment', [OrdersController::class, 'index'])->name('payment');
    Route::post('payment/store', [OrdersController::class, 'store'])->name('payment.store');
});


// Comment

Route::post('comments/store', [CommentsController::class, 'store'])->name('comments.store');
Route::get('comments/destroy', [CommentsController::class, 'destroy'] )->name('comments.destroy');

// Search
Route::post('search', [HomeController::class, 'search'])->name('search');

// sendmail

Route::post('sendmail', [SendMailController::class, 'store']);
