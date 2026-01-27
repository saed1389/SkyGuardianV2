<?php

use App\Http\Controllers\LanguageController;
use App\Livewire\AboutPage;
use App\Livewire\BlogIndex;
use App\Livewire\BlogShow;
use App\Livewire\CareersPage;
use App\Livewire\CompliancePage;
use App\Livewire\ContactPage;
use App\Livewire\LandingPage;
use App\Livewire\LicensePage;
use App\Livewire\PrivacyPage;
use App\Livewire\TermPage;
use Illuminate\Support\Facades\Route;


Route::get('/', LandingPage::class)->name('/');
Route::get('blog', BlogIndex::class)->name('blog.index');
Route::get('blog-show/{slug}', BlogShow::class)->name('blog.show');
Route::get('about-us', AboutPage::class)->name('about-page');
Route::get('careers', CareersPage::class)->name('careers-page');
Route::get('contact-us', ContactPage::class)->name('contact-page');
Route::get('term', TermPage::class)->name('term-page');
Route::get('privacy', PrivacyPage::class)->name('privacy-page');
Route::get('license', LicensePage::class)->name('license-page');
Route::get('compliance', CompliancePage::class)->name('compliance-page');


Route::post('/switch-language', [LanguageController::class, 'switch'])->name('language.switch');

require __DIR__.'/admin.php';
require __DIR__.'/user.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';
