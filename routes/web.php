<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\SocialiteController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; // <-- استيراد جديد
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\AttributeValueController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes (الواجهة الأمامية)
Route::get('/', function () {
    return view('welcome');
})->name('home');


// Auth Routes (روابط المصادقة)
// We are defining them manually to have full control
Route::middleware('guest')->group(function () {
    // login, register, forgot-password routes from auth.php can be copied here if needed
});
require __DIR__.'/auth.php'; // دعنا نبقي هذا مؤقتاً ونرى


// Admin Panel Routes (لوحة التحكم)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
    
    Route::resource('categories', CategoryController::class);
    Route::get('/categories/{category}/subcategories', [CategoryController::class, 'showSubcategories'])->name('categories.subcategories');
    
    Route::resource('products', ProductController::class);
    Route::delete('product-images/{image}', [ProductController::class, 'destroyImage'])->name('products.images.destroy');
    
    Route::resource('attributes', AttributeController::class);
    Route::get('attributes/{attribute}/values', [AttributeValueController::class, 'index'])->name('attributes.values.index');
    Route::resource('attributes.values', AttributeValueController::class)->except(['index', 'show']);

    // AJAX Routes
    Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories']);
    Route::get('/get-attributes/{categoryId}', [ProductController::class, 'getAttributes']);
});

// Socialite Routes
Route::get('/auth/{provider}/redirect', [SocialiteController::class, 'redirect'])->name('socialite.redirect');
Route::get('/auth/{provider}/callback', [SocialiteController::class, 'callback'])->name('socialite.callback');

// Language Switcher Route
Route::get('language/{locale}', function ($locale) {
    if (in_array($locale, config('app.available_locales'))) {
        session()->put('app_locale', $locale);
    }
    return redirect()->back();
})->name('language.switch');