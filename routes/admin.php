<?php
use App\Livewire\Back\HomePage;
use App\Livewire\Back\UserPage;

Route::middleware('auth', 'role:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', HomePage::class)->name('dashboard');
    Route::get('/users-list', UserPage::class)->name('users-list');
});
