<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Back\HomePage;
use App\Livewire\Back\UserPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth', 'role:admin')->prefix('admin')->name('admin.')->group(function () {
   Route::get('/dashboard', HomePage::class)->name('dashboard');
   Route::get('/users-list', UserPage::class)->name('users-list');
});

require __DIR__.'/auth.php';
