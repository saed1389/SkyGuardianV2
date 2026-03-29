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

Route::get('/linkedin/login', function () {
    $query = http_build_query([
        'response_type' => 'code',
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'redirect_uri' => env('LINKEDIN_REDIRECT_URI'),
        'scope' => 'w_member_social openid profile',
    ]);

    return redirect('https://www.linkedin.com/oauth/v2/authorization?' . $query);
});

Route::get('/linkedin/callback', function (\Illuminate\Http\Request $request) {
    Log::info('LinkedIn callback started', ['has_code' => $request->has('code')]);

    if ($request->has('error')) {
        Log::error('LinkedIn error', ['error' => $request->error_description]);
        return 'Error from LinkedIn: ' . $request->error_description;
    }

    $response = Http::asForm()->post('https://www.linkedin.com/oauth/v2/accessToken', [
        'grant_type' => 'authorization_code',
        'code' => $request->code,
        'redirect_uri' => env('LINKEDIN_REDIRECT_URI'),
        'client_id' => env('LINKEDIN_CLIENT_ID'),
        'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
    ]);

    Log::info('Token response', ['successful' => $response->successful(), 'status' => $response->status()]);

    if ($response->successful()) {
        $data = $response->json();
        Log::info('Storing tokens', ['has_access_token' => isset($data['access_token'])]);

        Cache::put('linkedin_access_token', $data['access_token'], now()->addDays(59));

        $profileResponse = Http::withHeaders([
            'Authorization' => 'Bearer ' . $data['access_token']
        ])->get('https://api.linkedin.com/v2/userinfo');

        Log::info('Profile response', ['successful' => $profileResponse->successful()]);

        if ($profileResponse->successful()) {
            $personId = $profileResponse->json('sub');
            Log::info('Storing person ID', ['person_id' => $personId]);
            Cache::put('linkedin_person_id', $personId, now()->addDays(59));
        }

        return 'Success! Your app is now connected to LinkedIn.';
    }

    Log::error('Failed to get token', ['response' => $response->body()]);
    return 'Failed to get token: ' . $response->body();
});

Route::get('/check-linkedin-cache', function () {
    $token = Cache::get('linkedin_access_token');
    $personId = Cache::get('linkedin_person_id');

    return [
        'access_token' => $token ? 'EXISTS ✓' : 'MISSING ✗',
        'person_id' => $personId ? 'EXISTS ✓' : 'MISSING ✗',
    ];
});

require __DIR__.'/admin.php';
require __DIR__.'/user.php';
require __DIR__.'/auth.php';
require __DIR__.'/api.php';
