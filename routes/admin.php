<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

// Admin Login Routes (No Auth Required)
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

// Admin Protected Routes
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AdminController::class, 'logout'])->name('logout');

    // Google Tags Settings
    Route::get('/settings/google-tags', [AdminController::class, 'googleTags'])->name('settings.google-tags');
    Route::post('/settings/google-tags', [AdminController::class, 'updateGoogleTags']);

    // Google Ads Settings
    Route::get('/settings/google-ads', [AdminController::class, 'googleAds'])->name('settings.google-ads');
    Route::post('/settings/google-ads', [AdminController::class, 'updateGoogleAds']);
});
