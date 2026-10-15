<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\Front\SiteController;
use Illuminate\Support\Facades\Route;

/* ---------- Public website ---------- */
Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'home')->name('home');
    Route::get('/products', 'products')->name('products');
    Route::get('/products/category/{category:slug}', 'products')->name('products.category');
    Route::get('/product/{slug}', 'product')->name('product');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'sendEnquiry')->middleware('throttle:6,1')->name('contact.send');
    Route::get('/blog', 'blog')->name('blog');
    Route::get('/blog/{slug}', 'post')->name('post');
    Route::get('/careers', 'careers')->name('careers');
    Route::get('/careers/{slug}', 'career')->name('career');
    Route::post('/careers/{slug}/apply', 'applyJob')->middleware('throttle:6,1')->name('career.apply');
    Route::get('/page/{slug}', 'page')->name('page');
});

/* ---------- Admin panel ---------- */
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    Route::resource('sliders', Admin\SliderController::class)->except('show');
    Route::resource('categories', Admin\CategoryController::class)->except('show');
    Route::resource('products', Admin\ProductController::class)->except('show');
    Route::resource('pages', Admin\PageController::class)->except('show');
    Route::resource('certifications', Admin\CertificationController::class)->except('show');
    Route::resource('posts', Admin\PostController::class)->except('show');
    Route::resource('jobs', Admin\JobOpeningController::class)->except('show');
    Route::resource('applications', Admin\JobApplicationController::class)->only(['index', 'show', 'destroy']);
    Route::get('applications/{application}/resume', [Admin\JobApplicationController::class, 'resume'])->name('applications.resume');
    Route::resource('enquiries', Admin\EnquiryController::class)->only(['index', 'show', 'destroy']);

    Route::get('settings', [Admin\SettingController::class, 'edit'])->name('settings');
    Route::post('settings', [Admin\SettingController::class, 'update'])->name('settings.update');
    Route::get('account', [Admin\AccountController::class, 'edit'])->name('account');
    Route::post('account', [Admin\AccountController::class, 'update'])->name('account.update');
});

require __DIR__.'/auth.php';
