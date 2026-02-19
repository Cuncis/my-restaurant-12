<?php

use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('menu');
});

Route::get('/menu', [MenuController::class, 'index'])->name('menu');

Route::get('/cart', function () {
    return view('customer.cart');
})->name('cart');

Route::get('/checkout', function () {
    return view('customer.checkout');
})->name('checkout');