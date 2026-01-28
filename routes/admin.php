<?php

use App\Livewire\Back\BlogPage;
use App\Livewire\Back\HomePage;
use App\Livewire\Back\PartnerPage;
use App\Livewire\Back\UserPage;
use App\Livewire\Back\Setting\DynamicPage;

Route::middleware('auth', 'role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', HomePage::class)->name('dashboard');
    Route::get('/users-list', UserPage::class)->name('users-list');
    Route::get('/blog-list', BlogPage::class)->name('blog-list');
    Route::get('/partners-list', PartnerPage::class)->name('partners-list');
    Route::prefix('settings')->name('settings.')->group(function () {
        Route::get('dynamic-page', DynamicPage::class)->name('dynamic-page');
    });
});
