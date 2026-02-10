<div>
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h1 class="h3 mb-0">
                                <i class="fas fa-clipboard-list me-2 text-primary"></i>
                                <span data-key="t-system-logs">System Logs</span>
                            </h1>
                            <button wire:click="$refresh" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-sync-alt me-1"></i> <span data-key="t-refresh">Refresh</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-primary text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase mb-2">Total Events</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['total'] }}</h3>
                                    </div>
                                    <i class="fas fa-layer-group fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-danger text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase mb-2">Critical Errors</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['critical'] }}</h3>
                                    </div>
                                    <i class="fas fa-exclamation-circle fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase mb-2">Warnings</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['warnings'] }}</h3>
                                    </div>
                                    <i class="fas fa-exclamation-triangle fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card bg-info text-white h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white-50 text-uppercase mb-2">Pending Retry</h6>
                                        <h3 class="mb-0 text-white">{{ $stats['retries'] }}</h3>
                                    </div>
                                    <i class="fas fa-redo fa-2x text-white-50"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label text-muted small">Search Logs</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            <input type="text" wire:model.live.debounce.300ms="search" class="form-control" placeholder="Search message, ID or context...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-muted small">Log Level</label>
                                        <select wire:model.live="filterType" class="form-select">
                                            <option value="all">All Levels</option>
                                            @foreach($filterOptions['types'] as $type)
                                                <option value="{{ $type }}">{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label text-muted small">Source</label>
                                        <select wire:model.live="filterSource" class="form-select">
                                            <option value="all">All Sources</option>
                                            @foreach($filterOptions['sources'] as $src)
                                                <option value="{{ $src }}">{{ $src }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2 d-flex align-items-end">
                                        <div class="d-grid w-100">
                                            <button wire:click="$set('search', '')" class="btn btn-light border">
                                                Reset
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover table-nowrap align-middle mb-0">
                                        <thead class="table-light">
                                        <tr>
                                            <th width="150">Timestamp</th>
                                            <th width="100">Level</th>
                                            <th width="150">Source</th>
                                            <th>Message</th>
                                            <th width="100" class="text-center">Retry</th>
                                            <th width="80">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($logs as $log)
                                            <tr>
                                                <td class="text-muted small">
                                                    <i class="far fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($log->logged_at)->format('Y-m-d H:i:s') }}
                                                </td>
                                                <td>
                                                    @php
                                                        $badgeClass = match($log->error_type) {
                                                            'CRITICAL' => 'bg-danger',
                                                            'ERROR' => 'bg-danger bg-opacity-75',
                                                            'WARNING' => 'bg-warning text-dark',
                                                            'INFO' => 'bg-info',
                                                            'DEBUG' => 'bg-secondary',
                                                            default => 'bg-primary'
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $badgeClass }} rounded-pill font-size-11">
                                                        {{ $log->error_type }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-light text-dark border">
                                                        {{ $log->source }}
                                                    </span>
                                                </td>
                                                <td class="text-truncate" style="max-width: 400px;">
                                                    <span class="fw-medium text-dark">{{ Str::limit($log->error_message, 80) }}</span>
                                                    <br>
                                                    <small class="text-muted font-monospace">{{ $log->error_id }}</small>
                                                </td>
                                                <td class="text-center">
                                                    @if($log->requires_retry)
                                                        <button wire:click="retryProcess('{{ $log->error_id }}')" class="btn btn-sm btn-soft-warning" title="Retry Operation">
                                                            <i class="fas fa-redo"></i>
                                                        </button>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <button wire:click="viewDetails('{{ $log->error_id }}')" class="btn btn-sm btn-link text-primary">
                                                        View
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="fas fa-check-circle fa-3x text-success mb-3 opacity-50"></i>
                                                        <h5>No logs found</h5>
                                                        <p class="mb-0">System is running smoothly or filters are too strict.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer border-top">
                                {{ $logs->links() }}
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @if($showModal && $selectedLog)
        <div class="modal fade show" tabindex="-1" style="display: block; background-color: rgba(0,0,0,0.5);" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <span class="badge bg-secondary me-2">{{ $selectedLog->error_type }}</span>
                            Log Details
                        </h5>
                        <button type="button" class="btn-close" wire:click="closeModal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="fw-bold text-muted small text-uppercase">Error Message</label>
                            <div class="alert alert-light border">
                                {{ $selectedLog->error_message }}
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="fw-bold text-muted small text-uppercase">Source</label>
                                <div class="form-control-plaintext py-0">{{ $selectedLog->source }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted small text-uppercase">Timestamp</label>
                                <div class="form-control-plaintext py-0">{{ $selectedLog->logged_at }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted small text-uppercase">Error ID</label>
                                <div class="form-control-plaintext py-0 font-monospace">{{ $selectedLog->error_id }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold text-muted small text-uppercase">Workflow Version</label>
                                <div class="form-control-plaintext py-0">{{ $selectedLog->workflow_version ?? 'N/A' }}</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold text-muted small text-uppercase">Technical Context (JSON)</label>
                            <div class="bg-dark text-light p-3 rounded" style="max-height: 300px; overflow-y: auto;">
                                @if($selectedLog->error_context)
                                    <pre class="mb-0" style="font-size: 12px; white-space: pre-wrap;">{{ json_encode(json_decode($selectedLog->error_context), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                                @else
                                    <span class="text-muted fst-italic">No context data available.</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        @if($selectedLog->requires_retry)
                            <button wire:click="retryProcess('{{ $selectedLog->error_id }}')" class="btn btn-warning">
                                <i class="fas fa-redo me-1"></i> Retry Process
                            </button>
                        @endif
                        <button type="button" class="btn btn-secondary" wire:click="closeModal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if (session()->has('message'))
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
            <div class="toast show align-items-center text-white bg-success border-0">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check-circle me-2"></i> {{ session('message') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
    @endif
</div>
