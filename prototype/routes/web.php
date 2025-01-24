<?php

use App\Models\Product;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::resource('/products', ProductController::class)->middleware('auth', 'role:admin');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Logout route to redirect to login after logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');
