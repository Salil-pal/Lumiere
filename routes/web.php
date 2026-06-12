<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Controllers
|--------------------------------------------------------------------------
*/

use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\SearchController;
use App\Http\Controllers\Frontend\AboutUsController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CheckoutController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\Frontend\StripeController;
use App\Http\Controllers\Frontend\StripeWebhookController;
use App\Http\Controllers\AuthController;



/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [WelcomeController::class, 'index'])->name('welcome.index');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop');
Route::get('/about-us', [AboutUsController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::get('/search', [SearchController::class, 'search'])->name('search');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| CART ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/remove-selected', [CartController::class, 'removeSelected'])->name('cart.removeSelected');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear');

});

/*
|--------------------------------------------------------------------------
| AUTH PROTECTED ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |-------------------------
    | CHECKOUT
    |-------------------------
    */

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/order-success/{id}', [CheckoutController::class, 'success'])->name('order.success');

    /*
    |-------------------------
    | ORDERS
    |-------------------------
    */

    Route::get('/my-orders', [OrderController::class, 'myOrders'])->name('orders.my');
    Route::get('/my-orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/track-order', [OrderController::class, 'trackForm'])->name('order.track.form');
    Route::post('/track-order', [OrderController::class, 'track'])->name('order.track');

    /*
    |-------------------------
    | STRIPE PAYMENT
    |-------------------------
    */

    Route::get('/stripe/checkout/{order}', [StripeController::class, 'checkout'])->name('stripe.checkout');
    Route::get('/stripe/success/{order}', [StripeController::class, 'success'])->name('stripe.success');

});

/*
|--------------------------------------------------------------------------
| WEBHOOK (NO AUTH REQUIRED)
|--------------------------------------------------------------------------
*/

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handleWebhook']);
