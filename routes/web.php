<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Models\categories;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group.
|
*/

// Public routes (guest only)
Route::middleware('guest')->group(function () {
    Route::get('/', [LoginController::class, 'show'])->name('home');

    // Show login form
    Route::get('/login', [LoginController::class, 'show'])->name('login');

    // Handle login submission
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

// Protected routes (authenticated only)
Route::middleware('auth')->group(function () {
    // Handle logout
    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');

    // Dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Product route
    Route::get('/product', [ProductController::class, 'index'])->name('product_page');

    // Order page (static user-facing view)
    // Note: moved to public routes for user accessibility

    Route::post('/save_product', [ProductController::class, 'Add_Product'])->name('save_product');

    Route::get('/All_data', [ProductController::class, 'index'])->name('all_product');

    Route::get('/edit_product/{id}', [ProductController::class, 'edit'])->name('edit_product');
    Route::post('/update_product/{id}', [ProductController::class, 'update'])->name('update_product');

    Route::delete('/delete_product/{id}', [ProductController::class, 'destroy'])->name('delete_product');

    Route::get('/search', [ProductController::class, 'search'])->name('search_product');

    Route::get('/category', [CategoriesController::class, 'category'])->name('product_category');

    Route::post('/add_category', [CategoriesController::class, 'addCategory'])->name('add_category');

    Route::delete('/delete_category/{id}', [CategoriesController::class, 'destroy'])->name('delete_category');

    Route::get('/category_search', [CategoriesController::class, 'search'])->name('search_category');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports');
});

Route::get('/order', [ProductController::class, 'order'])->name('order_page');

Route::get('/search_order', [ProductController::class, 'search_order'])->name('search_order');

Route::post('/addtocart', [CartController::class, 'addtocart'])->name('addtocart');

Route::get('/cart', [CartController::class,  'showcart'])->name('showcart');

Route::delete('/remove_from_cart/{id}', [CartController::class, 'remove'])->name('remove_from_cart');

Route::post('/payment', [CartController::class, 'payment'])->name('payment');

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
