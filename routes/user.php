<?php

use App\Livewire\User\HomePage;
use App\Livewire\User\MemberPage;

Route::middleware('auth', 'role:user')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', HomePage::class)->name('dashboard');
    Route::get('/members-list', MemberPage::class)->name('members-list');
});
