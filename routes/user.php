<?php

use App\Livewire\User\AircraftDatabasePage;
use App\Livewire\User\AnalysisHistoryPage;
use App\Livewire\User\HomePage;
use App\Livewire\User\LiveMapPage;
use App\Livewire\User\MemberPage;
use App\Livewire\User\MilitaryMonitorPage;
use App\Livewire\User\NatoReportsPage;
use App\Livewire\User\ReportsPage;
use App\Livewire\User\SensorStatusPage;
use App\Livewire\User\SystemLogsPage;
use App\Livewire\User\ThreatAnalysisPage;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {

    // --- Mission Control ---
    Route::get('/dashboard', HomePage::class)->name('dashboard');

    // --- Operations ---
    Route::get('live-map', LiveMapPage::class)->name('live-map');
    Route::get('military-monitor', MilitaryMonitorPage::class)->name('military-monitor');

    // --- Intelligence (C4ISR) ---
    Route::get('/ai-threat-analysis', ThreatAnalysisPage::class)->name('ai-threat-analysis');
    Route::get('nato-reports', NatoReportsPage::class)->name('nato-reports');
    Route::get('analysis-history', AnalysisHistoryPage::class)->name('analysis-history');
    Route::get('aircraft-database', AircraftDatabasePage::class)->name('aircraft-database');

    // --- Infrastructure ---
    Route::get('sensor-status', SensorStatusPage::class)->name('sensor-status');
    Route::get('system-logs', SystemLogsPage::class)->name('system-logs');

    // --- General Reports & Export ---
    Route::get('reports', ReportsPage::class)->name('reports');
    Route::get('/analyses/export/{type?}/{id?}', [App\Http\Controllers\ExportController::class, 'export'])->name('analyses.export');

    // --- Configuration ---
    Route::get('/members-list', MemberPage::class)->name('members-list');
});
