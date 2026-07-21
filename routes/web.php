<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminCategoryController;

// Public Catalog Routes
Route::get('/', [CatalogController::class, 'index'])->name('catalog.index');
Route::get('/cart', function () { return view('cart.index'); })->name('cart.index');
Route::get('/api/products', [CatalogController::class, 'index'])->name('catalog.api');
Route::get('/product/{id}', [CatalogController::class, 'show'])->name('catalog.show');
Route::get('/api/products/{id}/reviews', [\App\Http\Controllers\ReviewController::class, 'getReviews'])->name('products.reviews.get');

// Customer Auth Routes
Route::get('/login', [CustomerAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomerAuthController::class, 'login']);
Route::get('/register', [CustomerAuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [CustomerAuthController::class, 'register']);
Route::get('/auth/google', [CustomerAuthController::class, 'googleRedirect'])->name('auth.google');
Route::get('/auth/google/callback', [CustomerAuthController::class, 'googleCallback'])->name('auth.google.callback');
Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout');

// Customer Protected Routes (Logged-in Users Only)
Route::middleware(['auth'])->group(function () {
    Route::get('/chat/messages', [ChatController::class, 'userMessages'])->name('chat.user.messages');
    Route::post('/chat/send', [ChatController::class, 'userSend'])->name('chat.user.send');

    // Review Store Endpoint
    Route::post('/api/products/{id}/reviews', [\App\Http\Controllers\ReviewController::class, 'store'])->name('products.reviews.store');

    // Profile Settings Routes
    Route::get('/profile', [\App\Http\Controllers\UserProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [\App\Http\Controllers\UserProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [\App\Http\Controllers\UserProfileController::class, 'updatePassword'])->name('profile.password');
});

// Admin Auth Routes
Route::get('/cms-admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/cms-admin/login', [AdminAuthController::class, 'login']);
Route::post('/cms-admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// Protected Admin CMS Routes
Route::middleware(['auth'])->prefix('cms-admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('products', AdminProductController::class);
    Route::resource('categories', AdminCategoryController::class)->except(['create', 'edit', 'show']);

    // Admin Chat Endpoints
    Route::get('/chat', [ChatController::class, 'adminIndex'])->name('chat.index');
    Route::get('/chat/conversations', [ChatController::class, 'adminConversations'])->name('chat.conversations');
    Route::get('/chat/messages/{userId}', [ChatController::class, 'adminMessages'])->name('chat.messages');
    Route::post('/chat/send/{userId}', [ChatController::class, 'adminSend'])->name('chat.send');
    // Admin Orders Management
    Route::get('/orders', [\App\Http\Controllers\Admin\AdminOrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/{order}/status', [\App\Http\Controllers\Admin\AdminOrderController::class, 'updateStatus'])->name('orders.status');

    // Admin Reviews Management
    Route::get('/reviews', [\App\Http\Controllers\Admin\AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('/reviews/{review}', [\App\Http\Controllers\Admin\AdminReviewController::class, 'destroy'])->name('reviews.destroy');

    // Admin Banners Management
    Route::resource('banners', \App\Http\Controllers\Admin\AdminBannerController::class);
    Route::post('/banners/{id}/toggle', [\App\Http\Controllers\Admin\AdminBannerController::class, 'toggleStatus'])->name('banners.toggle');

    // Admin Settings Routes
    Route::get('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\AdminSettingsController::class, 'update'])->name('settings.update');
});
