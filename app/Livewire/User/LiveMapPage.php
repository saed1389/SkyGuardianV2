<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LiveMapPage extends Component
{
    public $aircraft = [];
    public $lastUpdate;
    public $totalAircraft = 0;
    public $militaryCount = 0;
    public $highThreatCount = 0;
    public $inEstoniaCount = 0;
    public $refreshing = false;
    public $filterType = 'all';
    public $filterCountry = 'all';
    public $filterThreatLevel = 'all';
    public $centerLat = 59.42;
    public $centerLon = 24.83;
    public $zoomLevel = 8;

    public function mount(): void
    {
        $this->loadAircraftData();
    }

    public function loadAircraftData(): void
    {
        $this->refreshing = true;

        $fiveMinutesAgo = Carbon::now('UTC')->subMinutes(5)->toIso8601String();

        $query = DB::table('skyguardian_positions as p')
            ->select([
                'p.id',
                'p.hex',
                DB::raw('CAST(p.latitude AS DECIMAL(10,6)) as latitude'),
                DB::raw('CAST(p.longitude AS DECIMAL(10,6)) as longitude'),
                DB::raw('CAST(p.altitude AS DECIMAL(10,2)) as altitude'),
                DB::raw('CAST(p.speed AS DECIMAL(10,2)) as speed'),
                DB::raw('CAST(p.heading AS DECIMAL(10,2)) as heading'),
                'p.threat_level',
                'p.in_estonia',
                'p.near_sensitive',
                'p.near_military_base',
                'p.near_border',
                'p.position_time',
                'a.callsign',
                'a.type',
                'a.aircraft_name',
                'a.country',
                'a.is_military',
                'a.is_drone',
                'a.is_nato',
                'a.is_potential_threat'
            ])
            ->leftJoin('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->where('p.position_time', '>', $fiveMinutesAgo)
            ->orderBy('p.hex', 'asc')
            ->orderBy('p.position_time', 'desc');

        if ($this->filterType === 'military') {
            $query->where('a.is_military', true);
        } elseif ($this->filterType === 'civil') {
            $query->where('a.is_military', false)->where('a.is_drone', false);
        } elseif ($this->filterType === 'drone') {
            $query->where('a.is_drone', true);
        }

        if ($this->filterCountry !== 'all') {
            $query->where('a.country', $this->filterCountry);
        }

        if ($this->filterThreatLevel !== 'all') {
            $query->where('p.threat_level', '>=', $this->filterThreatLevel);
        }

        $results = $query->get();

        $this->aircraft = $results->map(function ($item) {
            return [
                'hex' => $item->hex,
                'latitude' => floatval($item->latitude),
                'longitude' => floatval($item->longitude),
                'altitude' => floatval($item->altitude),
                'speed' => floatval($item->speed),
                'heading' => floatval($item->heading),
                'threat_level' => intval($item->threat_level),
                'in_estonia' => boolval($item->in_estonia),
                'near_sensitive' => boolval($item->near_sensitive),
                'near_military_base' => boolval($item->near_military_base),
                'near_border' => boolval($item->near_border),
                'position_time' => $item->position_time,
                'callsign' => $item->callsign ?? 'N/A',
                'type' => $item->type ?? 'unknown',
                'aircraft_name' => $item->aircraft_name ?? 'Unknown',
                'country' => $item->country ?? 'Unknown',
                'is_military' => boolval($item->is_military),
                'is_drone' => boolval($item->is_drone),
                'is_nato' => boolval($item->is_nato),
                'is_potential_threat' => boolval($item->is_potential_threat)
            ];
        })->toArray();

        $uniqueAircraft = collect($this->aircraft)->unique('hex');

        $this->totalAircraft = $uniqueAircraft->count();
        $this->militaryCount = $uniqueAircraft->where('is_military', true)->count();

        $this->highThreatCount = $uniqueAircraft->where('threat_level', '>=', 4)->count();
        $this->inEstoniaCount = $uniqueAircraft->where('in_estonia', true)->count();

        $this->lastUpdate = now()->format('H:i:s');
        $this->refreshing = false;

        $this->dispatch('aircraft-updated', aircraft: json_encode($this->aircraft));
    }

    public function applyFilters(): void
    {
        $this->loadAircraftData();
    }

    public function resetFilters(): void
    {
        $this->filterType = 'all';
        $this->filterCountry = 'all';
        $this->filterThreatLevel = 'all';
        $this->loadAircraftData();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $countries = DB::table('skyguardian_aircraft')
            ->whereNotNull('country')
            ->where('country', '!=', 'Unknown')
            ->distinct()
            ->pluck('country')
            ->toArray();

        return view('livewire.user.live-map-page', [
            'countries' => $countries
        ])->layout('components.layouts.userApp');
    }
}
