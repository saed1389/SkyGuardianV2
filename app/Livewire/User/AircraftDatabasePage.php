<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AircraftExport;

class AircraftDatabasePage extends Component
{
    public $aircraft = [];
    public $loading = false;
    public $stats = [];
    public $selectedAircraft = null;
    public $showDetailsModal = false;
    public $filterType = 'all';
    public $filterCountry = 'all';
    public $filterThreatLevel = 'all';
    public $filterStatus = 'all';
    public $search = '';
    public $perPage = 20;
    public $currentPage = 1;
    public $totalPages = 1;
    public $totalAircraft = 0;
    public $sortBy = 'last_seen';
    public $sortDirection = 'desc';

    public function mount(): void
    {
        $this->loadAircraft();
        $this->loadStats();
    }

    /**
     * Reusable query builder for both Table and Export
     */
    private function getFilteredQuery(): \Illuminate\Database\Query\Builder
    {
        $query = DB::table('skyguardian_aircraft as a')
            ->leftJoin('skyguardian_positions as p', function($join) {
                $join->on('a.hex', '=', 'p.hex')
                    ->where('p.position_time', '=', function($sub) {
                        $sub->select(DB::raw('MAX(position_time)'))
                            ->from('skyguardian_positions')
                            ->whereColumn('hex', 'a.hex');
                    });
            })
            ->select([
                'a.*',
                'p.latitude',
                'p.longitude',
                'p.altitude',
                'p.speed',
                'p.heading',
                'p.position_time',
                'p.in_estonia',
                'p.near_sensitive',
                'p.near_military_base',
                'p.near_border',
                'p.threat_level as position_threat_level'
            ]);

        if ($this->filterType === 'military') {
            $query->where('a.is_military', true);
        } elseif ($this->filterType === 'civil') {
            $query->where('a.is_military', false)->where('a.is_drone', false);
        } elseif ($this->filterType === 'drone') {
            $query->where('a.is_drone', true);
        } elseif ($this->filterType === 'nato') {
            $query->where('a.is_nato', true);
        }

        if ($this->filterCountry !== 'all') {
            $query->where('a.country', $this->filterCountry);
        }

        if ($this->filterThreatLevel !== 'all') {
            $query->where('a.threat_level', '>=', $this->filterThreatLevel);
        }

        if ($this->filterStatus === 'active') {
            $query->where('a.last_seen', '>=', Carbon::now()->subDay());
        } elseif ($this->filterStatus === 'inactive') {
            $query->where('a.last_seen', '<', Carbon::now()->subDay())->orWhereNull('a.last_seen');
        }

        if ($this->search) {
            $query->where(function($q) {
                $q->where('a.hex', 'like', '%' . $this->search . '%')
                    ->orWhere('a.callsign', 'like', '%' . $this->search . '%')
                    ->orWhere('a.registration', 'like', '%' . $this->search . '%')
                    ->orWhere('a.type', 'like', '%' . $this->search . '%')
                    ->orWhere('a.aircraft_name', 'like', '%' . $this->search . '%')
                    ->orWhere('a.country', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->sortBy === 'last_seen') {
            $query->orderBy('a.last_seen', $this->sortDirection);
        } elseif ($this->sortBy === 'threat_level') {
            $query->orderBy('a.threat_level', $this->sortDirection);
        } elseif ($this->sortBy === 'country') {
            $query->orderBy('a.country', $this->sortDirection);
        } else {
            $query->orderBy($this->sortBy, $this->sortDirection);
        }

        return $query;
    }

    public function loadAircraft(): void
    {
        $this->loading = true;

        $countQuery = DB::table('skyguardian_aircraft as a');

        $query = $this->getFilteredQuery();

        $this->totalAircraft = $query->count();
        $this->totalPages = ceil($this->totalAircraft / $this->perPage);

        $offset = ($this->currentPage - 1) * $this->perPage;
        $this->aircraft = $query->offset($offset)->limit($this->perPage)->get();

        $this->loading = false;
    }

    public function exportData(): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $query = $this->getFilteredQuery();

        $timestamp = Carbon::now()->format('Y-m-d_H-i');
        return Excel::download(new AircraftExport($query), "aircraft_database_{$timestamp}.xlsx");
    }

    public function exportSingleAircraft()
    {
        if (!$this->selectedAircraft) return;

        $query = $this->getFilteredQuery()->where('a.hex', $this->selectedAircraft->hex);

        $timestamp = Carbon::now()->format('Y-m-d');
        return Excel::download(new AircraftExport($query), "aircraft_{$this->selectedAircraft->hex}_{$timestamp}.xlsx");
    }

    public function loadStats(): void {
        $total = DB::table('skyguardian_aircraft')->count();
        $military = DB::table('skyguardian_aircraft')->where('is_military', true)->count();
        $drones = DB::table('skyguardian_aircraft')->where('is_drone', true)->count();
        $nato = DB::table('skyguardian_aircraft')->where('is_nato', true)->count();
        $active = DB::table('skyguardian_aircraft')->where('last_seen', '>=', Carbon::now()->subDay())->count();
        $countries = DB::table('skyguardian_aircraft')->whereNotNull('country')->select('country')->distinct()->count();
        $types = DB::table('skyguardian_aircraft')->whereNotNull('type')->select('type')->distinct()->count();
        $latest = DB::table('skyguardian_aircraft')->orderBy('created_at', 'desc')->first();

        $this->stats = [
            'total' => $total,
            'military' => $military,
            'drones' => $drones,
            'nato' => $nato,
            'active_24h' => $active,
            'countries' => $countries,
            'types' => $types,
            'latest' => $latest,
        ];
    }

    public function viewAircraftDetails($hex): void
    {
        $hex = trim($hex);

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

            $this->selectedAircraft->first_seen = DB::table('skyguardian_positions')
                ->where('hex', $hex)
                ->orderBy('position_time', 'asc')
                ->first();

            $this->showDetailsModal = true;
        }
    }

    public function closeModal(): void
    {
        $this->showDetailsModal = false;
        $this->selectedAircraft = null;
    }

    public function applyFilters(): void { $this->currentPage = 1; $this->loadAircraft(); $this->loadStats(); }
    public function resetFilters(): void {
        $this->filterType = 'all'; $this->filterCountry = 'all'; $this->filterThreatLevel = 'all';
        $this->filterStatus = 'all'; $this->search = ''; $this->sortBy = 'last_seen';
        $this->sortDirection = 'desc'; $this->applyFilters();
    }
    public function sort($column): void {
        if ($this->sortBy === $column) { $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc'; }
        else { $this->sortBy = $column; $this->sortDirection = 'asc'; }
        $this->loadAircraft();
    }
    public function previousPage(): void { if ($this->currentPage > 1) { $this->currentPage--; $this->loadAircraft(); } }
    public function nextPage(): void { if ($this->currentPage < $this->totalPages) { $this->currentPage++; $this->loadAircraft(); } }
    public function goToPage($page): void { if ($page >= 1 && $page <= $this->totalPages) { $this->currentPage = $page; $this->loadAircraft(); } }
    public function refreshData(): void { $this->loadAircraft(); $this->loadStats(); }
    public function getCountryOptions(): array {
        return DB::table('skyguardian_aircraft')->whereNotNull('country')->select('country')->distinct()->orderBy('country')->pluck('country')->toArray();
    }

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        return view('livewire.user.aircraft-database-page', [
            'countryOptions' => $this->getCountryOptions(),
        ])->layout('components.layouts.userApp');
    }
}
