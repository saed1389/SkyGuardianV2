<?php

use App\Livewire\User\AircraftDatabasePage;
use App\Livewire\User\AnalysisHistoryPage;
use App\Livewire\User\HomePage;
use App\Livewire\User\LiveMapPage;
use App\Livewire\User\MemberPage;
use App\Livewire\User\MilitaryMonitorPage;
use App\Livewire\User\ReportsPage;
use App\Livewire\User\SystemLogsPage;
use App\Livewire\User\ThreatAnalysisPage;

Route::middleware('auth', 'role:user')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', HomePage::class)->name('dashboard');
    Route::get('/members-list', MemberPage::class)->name('members-list');

    Route::get('live-map', LiveMapPage::class)->name('live-map');
    Route::get('/ai-threat-analysis', ThreatAnalysisPage::class)->name('ai-threat-analysis');
    Route::get('analysis-history', AnalysisHistoryPage::class)->name('analysis-history');
    Route::get('military-monitor', MilitaryMonitorPage::class)->name('military-monitor');
    Route::get('aircraft-database', AircraftDatabasePage::class)->name('aircraft-database');
    Route::get('system-logs', SystemLogsPage::class)->name('system-logs');
    Route::get('reports', ReportsPage::class)->name('reports');
});
