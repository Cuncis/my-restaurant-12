<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('menu');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/cart', [MenuController::class, 'cart'])->name('cart');
Route::post('/cart/add', [MenuController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{id}', [MenuController::class, 'updateCart'])->name('cart.update');
Route::delete('/cart/remove/{id}', [MenuController::class, 'removeFromCart'])->name('cart.remove');
Route::delete('/cart/clear', [MenuController::class, 'clearCart'])->name('cart.clear');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

Route::get('/order/success/{id}', function ($id) {
    $order = \App\Models\Order::with(['orderItems.item', 'user'])->findOrFail($id);
    $snapToken = session('snap_token');
    return view('customer.order-success', compact('order', 'snapToken'));
})->name('order.success');

// Admin routes
Route::resource('/dashboard', DashboardController::class);
Route::resource('/categories', CategoryController::class);
Route::resource('/items', ItemController::class);
Route::resource('/roles', RoleController::class);
Route::resource('/users', UserController::class);
Route::resource('/orders', OrderController::class);