<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SystemLogsPage extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filtreler
    public $search = '';
    public $filterType = 'all';
    public $filterSource = 'all';
    public $perPage = 20;

    // Modal
    public $selectedLog = null;
    public $showModal = false;

    // İstatistikler (Canlı hesaplanacak)
    public $stats = [];

    public function mount()
    {
        $this->calculateStats();
    }

    public function calculateStats()
    {
        // Basit istatistikler
        $this->stats = [
            'total' => DB::table('skyguardian_errors')->count(),
            'critical' => DB::table('skyguardian_errors')->where('error_type', 'CRITICAL')->count(),
            'warnings' => DB::table('skyguardian_errors')->where('error_type', 'WARNING')->count(),
            'retries' => DB::table('skyguardian_errors')->where('requires_retry', true)->count(),
        ];
    }

    public function viewDetails($errorId)
    {
        $this->selectedLog = DB::table('skyguardian_errors')
            ->where('error_id', $errorId)
            ->first();

        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedLog = null;
    }

    public function retryProcess($errorId)
    {
        // Burada gerçek bir retry mekanizması tetiklenebilir (Queue, Job vs.)
        // Şimdilik sadece simülasyon yapıyoruz.
        DB::table('skyguardian_errors')
            ->where('error_id', $errorId)
            ->update(['requires_retry' => false, 'updated_at' => now()]);

        session()->flash('message', 'Retry signal sent for Error ID: ' . $errorId);
        $this->calculateStats();
    }

    // Dropdown seçenekleri için veritabanındaki benzersiz değerleri çeker
    public function getFilterOptionsProperty()
    {
        return [
            'types' => DB::table('skyguardian_errors')->select('error_type')->distinct()->pluck('error_type'),
            'sources' => DB::table('skyguardian_errors')->select('source')->distinct()->pluck('source'),
        ];
    }

    public function updatedSearch() { $this->resetPage(); }
    public function updatedFilterType() { $this->resetPage(); }

    public function render()
    {
        $query = DB::table('skyguardian_errors')
            ->orderBy('logged_at', 'desc');

        if ($this->search) {
            $query->where(function($q) {
                $q->where('error_message', 'like', '%' . $this->search . '%')
                    ->orWhere('error_id', 'like', '%' . $this->search . '%')
                    ->orWhere('error_context', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->filterType !== 'all') {
            $query->where('error_type', $this->filterType);
        }

        if ($this->filterSource !== 'all') {
            $query->where('source', $this->filterSource);
        }

        return view('livewire.user.system-logs-page', [
            'logs' => $query->paginate($this->perPage),
            'filterOptions' => $this->getFilterOptionsProperty()
        ])->layout('components.layouts.userApp');
    }
}
