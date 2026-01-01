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
    public $refreshing = false;

    // For filters
    public $filterType = 'all';
    public $filterCountry = 'all';
    public $filterThreatLevel = 'all';

    // Map settings
    public $centerLat = 59.42;
    public $centerLon = 24.83;
    public $zoomLevel = 8;

    public function mount()
    {
        $this->loadAircraftData();
    }

    public function loadAircraftData()
    {
        $this->refreshing = true;

        $fiveMinutesAgo = Carbon::now('UTC')->subMinutes(5)->toIso8601String();

        // Get all positions from last 5 minutes (including historical)
        $query = DB::table('skyguardian_positions as p')
            ->select([
                'p.id', // Add ID to distinguish duplicate positions
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

        // Apply filters
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

        // Get raw results
        $results = $query->get();

        \Log::info("Query returned {$results->count()} aircraft from last 5 minutes (UTC)");

        if ($results->count() > 0) {
            \Log::info("Position time range:", [
                'newest' => $results->first()->position_time,
                'oldest' => $results->last()->position_time
            ]);
        }

        // Convert to proper format
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
                'position_time' => $item->position_time, // Keep as ISO string
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

        $this->totalAircraft = count($this->aircraft);
        $this->militaryCount = collect($this->aircraft)->where('is_military', true)->count();
        $this->lastUpdate = now()->format('H:i:s');

        $this->refreshing = false;

        // Dispatch event with JSON-encoded data
        $this->dispatch('aircraft-updated', aircraft: json_encode($this->aircraft));
    }

    public function applyFilters()
    {
        $this->loadAircraftData();
    }

    public function resetFilters()
    {
        $this->filterType = 'all';
        $this->filterCountry = 'all';
        $this->filterThreatLevel = 'all';
        $this->loadAircraftData();
    }

    public function render()
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
