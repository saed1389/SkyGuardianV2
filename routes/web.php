<?php

use App\Http\Controllers\LanguageController;
use App\Livewire\AboutPage;
use App\Livewire\BlogIndex;
use App\Livewire\BlogShow;
use App\Livewire\LandingPage;
use Illuminate\Support\Facades\Route;


Route::get('/', LandingPage::class)->name('/');
Route::get('blog', BlogIndex::class)->name('blog.index');
Route::get('blog-show/{slug}', BlogShow::class)->name('blog.show');
Route::get('about-us', AboutPage::class)->name('about-page');


Route::post('/switch-language', [LanguageController::class, 'switch'])->name('language.switch');

require __DIR__.'/admin.php';
require __DIR__.'/user.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';
