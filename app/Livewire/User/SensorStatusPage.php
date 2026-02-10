<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class SensorStatusPage extends Component
{
    public $sensors;
    public $scanResult = null;
    public $isScanning = false;

    public function mount(): void
    {
        $this->refreshSensors();
    }

    public function refreshSensors(): void
    {
        $this->sensors = DB::table('skyguardian_sensors')->get();
    }

    public function triggerRemoteScan(): void
    {
        $this->isScanning = true;

        $raspberryUrl = 'https://lifelong-tanya-lifelessly.ngrok-free.dev/scan-result';

        try {
            $response = Http::withoutVerifying()->timeout(10)->get($raspberryUrl);

            if ($response->successful()) {
                $rawData = $response->json();

                $processedData = collect($rawData['data'])
                    ->sortBy('freq_hz')
                    ->map(function ($item) {
                        return [
                            'x' => round($item['freq_hz'] / 1000000, 1),
                            'y' => $item['power_db']
                        ];
                    })->values()->toArray();

                $this->dispatch('rf-scan-completed', [
                    'series' => $processedData,
                    'timestamp' => $rawData['timestamp']
                ]);

                session()->flash('message', 'Spectrum Scan Completed: ' . count($processedData) . ' points analyzed.');
            } else {
                session()->flash('error', 'Sensor unreachable: ' . $response->status());
            }

        } catch (\Exception $e) {
            session()->flash('error', 'Connection failed: ' . $e->getMessage());
        }

        $this->isScanning = false;
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.user.sensor-status-page')->layout('components.layouts.userApp');
    }
}
