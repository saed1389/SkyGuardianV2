<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MilitaryMonitorPage extends Component
{
    public $militaryAircraft = [];
    public $activePositions = [];
    public $stats = [];
    public $loading = false;
    public $selectedAircraft = null;
    public $showDetailsModal = false;

    // Filters
    public $filterCountry = 'all';
    public $filterThreatLevel = 'all';
    public $filterStatus = 'all'; // active, inactive
    public $filterType = 'all'; // military, drone, nato
    public $search = '';

    // Time range for positions
    public $timeRange = '1hour'; // 1hour, 6hours, 24hours, 7days

    // Map settings
    public $centerLat = 59.42;
    public $centerLon = 24.83;
    public $zoomLevel = 8;

    public function mount()
    {
        $this->loadMilitaryAircraft();
        $this->loadStats();
    }

    public function loadMilitaryAircraft()
    {
        $this->loading = true;

        // Get military aircraft
        $aircraftQuery = DB::table('skyguardian_aircraft as a')
            ->where('a.is_military', true)
            ->orderBy('a.threat_level', 'desc')
            ->orderBy('a.last_seen', 'desc');

        // Apply filters
        if ($this->filterCountry !== 'all') {
            $aircraftQuery->where('a.country', $this->filterCountry);
        }

        if ($this->filterThreatLevel !== 'all') {
            $aircraftQuery->where('a.threat_level', '>=', $this->filterThreatLevel);
        }

        if ($this->filterType === 'drone') {
            $aircraftQuery->where('a.is_drone', true);
        } elseif ($this->filterType === 'nato') {
            $aircraftQuery->where('a.is_nato', true);
        }

        if ($this->search) {
            $aircraftQuery->where(function($q) {
                $q->where('a.callsign', 'like', '%' . $this->search . '%')
                    ->orWhere('a.registration', 'like', '%' . $this->search . '%')
                    ->orWhere('a.type', 'like', '%' . $this->search . '%')
                    ->orWhere('a.hex', 'like', '%' . $this->search . '%');
            });
        }

        $this->militaryAircraft = $aircraftQuery->get();

        // Get active positions for these aircraft
        $this->loadActivePositions();

        $this->loading = false;
    }

    public function loadActivePositions()
    {
        $timeThreshold = match($this->timeRange) {
            '1hour' => Carbon::now()->subHour(),
            '6hours' => Carbon::now()->subHours(6),
            '24hours' => Carbon::now()->subDay(),
            '7days' => Carbon::now()->subDays(7),
            default => Carbon::now()->subHour(),
        };

        // Get latest positions for military aircraft
        $hexCodes = $this->militaryAircraft->pluck('hex')->toArray();

        if (!empty($hexCodes)) {
            // Get latest position for each aircraft
            $latestPositions = DB::table('skyguardian_positions')
                ->select('hex', DB::raw('MAX(position_time) as latest_time'))
                ->whereIn('hex', $hexCodes)
                ->where('position_time', '>=', $timeThreshold)
                ->groupBy('hex')
                ->get()
                ->keyBy('hex');

            // Get the actual position data
            $positions = DB::table('skyguardian_positions as p')
                ->select('p.*')
                ->whereIn('p.hex', $hexCodes)
                ->where('p.position_time', '>=', $timeThreshold)
                ->joinSub(
                    DB::table('skyguardian_positions')
                        ->select('hex', DB::raw('MAX(position_time) as latest_time'))
                        ->whereIn('hex', $hexCodes)
                        ->where('position_time', '>=', $timeThreshold)
                        ->groupBy('hex'),
                    'latest',
                    function($join) {
                        $join->on('p.hex', '=', 'latest.hex')
                            ->on('p.position_time', '=', 'latest.latest_time');
                    }
                )
                ->get();

            $this->activePositions = $positions->keyBy('hex');
        } else {
            $this->activePositions = [];
        }
    }

    public function loadStats()
    {
        // Total military aircraft
        $totalMilitary = DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->count();

        // Active in last 24 hours
        $activeLast24h = DB::table('skyguardian_aircraft as a')
            ->join('skyguardian_positions as p', 'a.hex', '=', 'p.hex')
            ->where('a.is_military', true)
            ->where('p.position_time', '>=', Carbon::now()->subDay())
            ->distinct('a.hex')
            ->count('a.hex');

        // By threat level
        $threatLevels = DB::table('skyguardian_aircraft')
            ->select('threat_level', DB::raw('COUNT(*) as count'))
            ->where('is_military', true)
            ->groupBy('threat_level')
            ->orderBy('threat_level', 'desc')
            ->get()
            ->pluck('count', 'threat_level')
            ->toArray();

        // By country
        $countries = DB::table('skyguardian_aircraft')
            ->select('country', DB::raw('COUNT(*) as count'))
            ->where('is_military', true)
            ->whereNotNull('country')
            ->groupBy('country')
            ->orderBy('count', 'desc')
            ->limit(5)
            ->get()
            ->pluck('count', 'country')
            ->toArray();

        // Drones
        $drones = DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->where('is_drone', true)
            ->count();

        // NATO aircraft
        $nato = DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->where('is_nato', true)
            ->count();

        // Latest military activity
        $latestActivity = DB::table('skyguardian_positions as p')
            ->join('skyguardian_aircraft as a', 'p.hex', '=', 'a.hex')
            ->where('a.is_military', true)
            ->orderBy('p.position_time', 'desc')
            ->select('p.*', 'a.*')
            ->first();

        $this->stats = [
            'total_military' => $totalMilitary,
            'active_last_24h' => $activeLast24h,
            'threat_levels' => $threatLevels,
            'top_countries' => $countries,
            'drones' => $drones,
            'nato' => $nato,
            'latest_activity' => $latestActivity,
        ];
    }

    public function viewAircraftDetails($hex)
    {
        $this->selectedAircraft = DB::table('skyguardian_aircraft')
            ->where('hex', $hex)
            ->first();

        if ($this->selectedAircraft) {
            // Get position history for this aircraft
            $this->selectedAircraft->positions = DB::table('skyguardian_positions')
                ->where('hex', $hex)
                ->orderBy('position_time', 'desc')
                ->limit(50)
                ->get();

            // Get latest position
            $this->selectedAircraft->latest_position = DB::table('skyguardian_positions')
                ->where('hex', $hex)
                ->orderBy('position_time', 'desc')
                ->first();
        }

        $this->showDetailsModal = true;
    }

    public function closeModal()
    {
        $this->showDetailsModal = false;
        $this->selectedAircraft = null;
    }

    public function applyFilters()
    {
        $this->loadMilitaryAircraft();
        $this->loadStats();
    }

    public function resetFilters()
    {
        $this->filterCountry = 'all';
        $this->filterThreatLevel = 'all';
        $this->filterStatus = 'all';
        $this->filterType = 'all';
        $this->search = '';
        $this->timeRange = '1hour';
        $this->applyFilters();
    }

    public function refreshData()
    {
        $this->loadMilitaryAircraft();
        $this->loadStats();
        $this->dispatch('map-refreshed', markers: $this->getMapMarkersData());
    }

    public function getAircraftPositionsProperty()
    {
        // Combine aircraft data with positions
        $aircraftWithPositions = [];

        foreach ($this->militaryAircraft as $aircraft) {
            $position = $this->activePositions[$aircraft->hex] ?? null;

            $aircraftWithPositions[] = (object) [
                'aircraft' => $aircraft,
                'position' => $position,
                'is_active' => $position && Carbon::parse($position->position_time)->diffInMinutes(Carbon::now()) < 30,
            ];
        }

        return $aircraftWithPositions;
    }

    public function getCountryOptions()
    {
        return DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->whereNotNull('country')
            ->select('country')
            ->distinct()
            ->orderBy('country')
            ->pluck('country')
            ->toArray();
    }

    public function getMapMarkersData()
    {
        $markers = [];

        foreach ($this->aircraftPositions as $item) {
            if ($item->position && $item->position->latitude && $item->position->longitude) {
                $markers[] = [
                    'hex' => $item->aircraft->hex,
                    'callsign' => $item->aircraft->callsign,
                    'type' => $item->aircraft->type,
                    'country' => $item->aircraft->country,
                    'threat_level' => $item->aircraft->threat_level,
                    'is_drone' => $item->aircraft->is_drone,
                    'is_nato' => $item->aircraft->is_nato,
                    'latitude' => $item->position->latitude,
                    'longitude' => $item->position->longitude,
                    'altitude' => $item->position->altitude,
                    'speed' => $item->position->speed,
                    'heading' => $item->position->heading,
                    'position_time' => $item->position->position_time,
                    'in_estonia' => $item->position->in_estonia,
                    'near_sensitive' => $item->position->near_sensitive,
                    'is_active' => $item->is_active,
                ];
            }
        }

        return $markers;
    }

    public function render()
    {
        return view('livewire.user.military-monitor-page', [
            'countryOptions' => $this->getCountryOptions(),
            'aircraftPositions' => $this->aircraftPositions,
            'mapMarkersData' => $this->getMapMarkersData(),
        ])->layout('components.layouts.userApp');
    }
}
