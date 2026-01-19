<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination; // 1. Import Trait
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MilitaryMonitorPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $militaryAircraft = [];
    public $activePositions = [];
    public $stats = [];
    public $loading = false;
    public $selectedAircraft = null;
    public $showDetailsModal = false;
    public $filterCountry = 'all';
    public $filterThreatLevel = 'all';
    public $filterStatus = 'all';
    public $filterType = 'all';
    public $search = '';
    public $perPage = 10;
    public $timeRange = '1hour';
    public $centerLat = 59.42;
    public $centerLon = 24.83;
    public $zoomLevel = 8;

    public function mount(): void
    {
        $this->refreshData();
    }

    private function getFilteredAircraftQuery(): \Illuminate\Database\Query\Builder
    {
        $query = DB::table('skyguardian_aircraft as a')
            ->where('a.is_military', true)
            ->orderBy('a.threat_level', 'desc') // High threat first
            ->orderBy('a.last_seen', 'desc');   // Most recent second

        if ($this->filterCountry !== 'all') {
            $query->where('a.country', $this->filterCountry);
        }

        if ($this->filterThreatLevel !== 'all') {
            $query->where('a.threat_level', '>=', $this->filterThreatLevel);
        }

        if ($this->filterType === 'drone') {
            $query->where('a.is_drone', true);
        } elseif ($this->filterType === 'nato') {
            $query->where('a.is_nato', true);
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('a.callsign', 'like', '%' . $this->search . '%')
                    ->orWhere('a.registration', 'like', '%' . $this->search . '%')
                    ->orWhere('a.type', 'like', '%' . $this->search . '%')
                    ->orWhere('a.hex', 'like', '%' . $this->search . '%');
            });
        }

        return $query;
    }

    public function loadMilitaryAircraft(): void
    {
        $this->loading = true;

        $this->militaryAircraft = $this->getFilteredAircraftQuery()->get();

        $this->loadActivePositions();

        $this->loading = false;
    }

    public function loadActivePositions(): void
    {
        $timeThreshold = match($this->timeRange) {
            '1hour' => Carbon::now()->subHour(),
            '6hours' => Carbon::now()->subHours(6),
            '24hours' => Carbon::now()->subDay(),
            '7days' => Carbon::now()->subDays(7),
            default => Carbon::now()->subHour(),
        };

        $hexCodes = $this->militaryAircraft->pluck('hex')->toArray();

        if (!empty($hexCodes)) {

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

    public function loadStats(): void
    {
        $totalMilitary = DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->count();

        $activeLast24h = DB::table('skyguardian_aircraft as a')
            ->join('skyguardian_positions as p', 'a.hex', '=', 'p.hex')
            ->where('a.is_military', true)
            ->where('p.position_time', '>=', Carbon::now()->subDay())
            ->distinct('a.hex')
            ->count('a.hex');

        $threatLevels = DB::table('skyguardian_aircraft')
            ->select('threat_level', DB::raw('COUNT(*) as count'))
            ->where('is_military', true)
            ->groupBy('threat_level')
            ->orderBy('threat_level', 'desc')
            ->get()
            ->pluck('count', 'threat_level')
            ->toArray();

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

        $drones = DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->where('is_drone', true)
            ->count();

        $nato = DB::table('skyguardian_aircraft')
            ->where('is_military', true)
            ->where('is_nato', true)
            ->count();

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

    public function formatAircraftForTable($aircraftCollection): array
    {
        $formatted = [];
        foreach ($aircraftCollection as $aircraft) {

            $position = $this->activePositions[$aircraft->hex] ?? null;

            $formatted[] = (object) [
                'aircraft' => $aircraft,
                'position' => $position,
                'is_active' => $position && Carbon::parse($position->position_time)->diffInMinutes(Carbon::now()) < 30,
            ];
        }
        return $formatted;
    }

    public function applyFilters(): void
    {
        $this->resetPage();
        $this->refreshData();
    }

    public function resetFilters(): void
    {
        $this->resetPage();
        $this->filterCountry = 'all';
        $this->filterThreatLevel = 'all';
        $this->filterStatus = 'all';
        $this->filterType = 'all';
        $this->search = '';
        $this->timeRange = '1hour';
        $this->refreshData();
    }

    public function refreshData(): void
    {
        $this->loadMilitaryAircraft();
        $this->loadStats();
        $this->dispatch('map-refreshed', markers: $this->getMapMarkersData());
    }

    public function viewAircraftDetails($hex): void
    {
        $this->selectedAircraft = DB::table('skyguardian_aircraft')
            ->where('hex', $hex)
            ->first();

        if ($this->selectedAircraft) {
            $this->selectedAircraft->positions = DB::table('skyguardian_positions')
                ->where('hex', $hex)
                ->orderBy('position_time', 'desc')
                ->limit(50)
                ->get();

            $this->selectedAircraft->latest_position = DB::table('skyguardian_positions')
                ->where('hex', $hex)
                ->orderBy('position_time', 'desc')
                ->first();
        }
        $this->showDetailsModal = true;
    }

    public function closeModal(): void
    {
        $this->showDetailsModal = false;
        $this->selectedAircraft = null;
    }

    public function getCountryOptions(): array
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

    public function getAircraftPositionsProperty(): array
    {
        return $this->formatAircraftForTable($this->militaryAircraft);
    }

    public function getMapMarkersData(): array
    {
        $markers = [];
        foreach ($this->getAircraftPositionsProperty() as $item) {
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

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $paginatedAircraft = $this->getFilteredAircraftQuery()->paginate($this->perPage);

        $paginatedCollection = $paginatedAircraft->getCollection()->map(function($aircraft) {
            $position = $this->activePositions[$aircraft->hex] ?? null;
            return (object) [
                'aircraft' => $aircraft,
                'position' => $position,
                'is_active' => $position && Carbon::parse($position->position_time)->diffInMinutes(Carbon::now()) < 30,
            ];
        });

        $paginatedAircraft->setCollection($paginatedCollection);

        return view('livewire.user.military-monitor-page', [
            'countryOptions' => $this->getCountryOptions(),
            'paginatedAircraft' => $paginatedAircraft,
            'mapMarkersData' => $this->getMapMarkersData(),
            'aircraftPositions' => $this->aircraftPositions,
        ])->layout('components.layouts.userApp');
    }
}
