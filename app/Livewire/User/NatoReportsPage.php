<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class NatoReportsPage extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $report_id;
    public $salute_size;
    public $salute_activity;
    public $salute_location;
    public $salute_unit;
    public $salute_time;
    public $salute_equipment;
    public $threat_level = 'LOW';
    public $full_report_text;
    public $isEditMode = false;
    public $showModal = false;
    public $showDetailsModal = false;
    public $selectedReport = null;
    public $search = '';
    public $filterThreat = 'all';
    public $filterStatus = 'all';

    protected $rules = [
        'salute_size' => 'required|string|max:100',
        'salute_activity' => 'required|string',
        'salute_location' => 'required|string',
        'salute_unit' => 'nullable|string',
        'salute_time' => 'required|string',
        'salute_equipment' => 'nullable|string',
        'threat_level' => 'required|in:LOW,MEDIUM,HIGH,CRITICAL',
    ];

    public function render(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\View\View
    {
        $query = DB::table('skyguardian_nato_reports')
            ->orderBy('timestamp', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('report_id', 'like', '%' . $this->search . '%')
                    ->orWhere('salute_activity', 'like', '%' . $this->search . '%')
                    ->orWhere('salute_location', 'like', '%' . $this->search . '%')
                    ->orWhere('salute_unit', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterThreat !== 'all') {
            $query->where('threat_level', $this->filterThreat);
        }

        if ($this->filterStatus === 'transmitted') {
            $query->where('is_transmitted', true);
        } elseif ($this->filterStatus === 'pending') {
            $query->where('is_transmitted', false);
        }

        $reports = $query->paginate(10);

        $stats = [
            'total' => DB::table('skyguardian_nato_reports')->count(),
            'high_threat' => DB::table('skyguardian_nato_reports')->whereIn('threat_level', ['HIGH', 'CRITICAL'])->count(),
            'today' => DB::table('skyguardian_nato_reports')->whereDate('timestamp', Carbon::today())->count(),
            'pending' => DB::table('skyguardian_nato_reports')->where('is_transmitted', false)->count(),
        ];

        return view('livewire.user.nato-reports-page', [
            'reports' => $reports,
            'stats' => $stats
        ])->layout('components.layouts.userApp');
    }

    public function create(): void
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->salute_time = Carbon::now()->format('dHi\Z M y');
        $this->showModal = true;
    }

    public function store(): void
    {
        $this->validate();

        $this->full_report_text = "SIZE: $this->salute_size | ACT: $this->salute_activity | LOC: $this->salute_location | UNIT: $this->salute_unit | TIME: $this->salute_time | EQ: $this->salute_equipment";

        $data = [
            'salute_size' => $this->salute_size,
            'salute_activity' => $this->salute_activity,
            'salute_location' => $this->salute_location,
            'salute_unit' => $this->salute_unit,
            'salute_time' => $this->salute_time,
            'salute_equipment' => $this->salute_equipment,
            'threat_level' => $this->threat_level,
            'full_report_text' => $this->full_report_text,
            'updated_at' => now(),
        ];

        if ($this->isEditMode && $this->report_id) {
            DB::table('skyguardian_nato_reports')->where('report_id', $this->report_id)->update($data);
             session()->flash('message', 'Report updated.');
        } else {
            $data['report_id'] = 'SAL-' . strtoupper(Str::random(6));
            $data['timestamp'] = now();
            $data['report_type'] = 'SALUTE';
            $data['is_transmitted'] = false;
            $data['created_at'] = now();

            DB::table('skyguardian_nato_reports')->insert($data);
            session()->flash('message', 'SALUTE Report created.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id): void
    {
        $report = DB::table('skyguardian_nato_reports')->where('report_id', $id)->first();
        if ($report) {
            $this->report_id = $report->report_id;
            $this->salute_size = $report->salute_size;
            $this->salute_activity = $report->salute_activity;
            $this->salute_location = $report->salute_location;
            $this->salute_unit = $report->salute_unit;
            $this->salute_time = $report->salute_time;
            $this->salute_equipment = $report->salute_equipment;
            $this->threat_level = $report->threat_level;

            $this->isEditMode = true;
            $this->showModal = true;
        }
    }

    public function viewDetails($id): void
    {
        $this->selectedReport = DB::table('skyguardian_nato_reports')->where('report_id', $id)->first();
        $this->showDetailsModal = true;
    }

    public function toggleTransmit($id): void
    {
        $report = DB::table('skyguardian_nato_reports')->where('report_id', $id)->first();
        if ($report) {
            DB::table('skyguardian_nato_reports')
                ->where('report_id', $id)
                ->update(['is_transmitted' => !$report->is_transmitted]);
        }
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->showDetailsModal = false;
        $this->resetInputFields();
    }

    private function resetInputFields(): void
    {
        $this->salute_size = '';
        $this->salute_activity = '';
        $this->salute_location = '';
        $this->salute_unit = '';
        $this->salute_time = '';
        $this->salute_equipment = '';
        $this->threat_level = 'LOW';
        $this->report_id = null;
        $this->selectedReport = null;
    }
}
