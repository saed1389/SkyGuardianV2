<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Back\HomePage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth', 'verified')->group(function () {
   Route::get('/dashboard', HomePage::class)->name('dashboard');
});

require __DIR__.'/auth.php';
