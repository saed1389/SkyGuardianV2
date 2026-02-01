<div>
    @push('styles')
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            .form-switch .form-check-input { width: 2.5em; height: 1.25em; cursor: pointer; }
            .pagination-container { margin: 60px 0 100px; display: flex; justify-content: center; width: 100%; }
            .custom-pagination { background: #ffffff; border-radius: 50px; padding: 8px 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.08); border: 1px solid var(--gray-200); display: flex; align-items: center; gap: 8px; }
            .page-item { width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: transparent; border: none; font-family: inherit; font-weight: 700; font-size: 14px; color: var(--gray-500); cursor: pointer; transition: all 0.2s ease; }
            .page-item:hover:not(.active):not(.disabled) { background: var(--gray-50); color: var(--black); transform: translateY(-2px); }
            .page-item.active { background: var(--primary-blue); color: blue; box-shadow: 0 4px 12px rgba(0, 114, 206, 0.4); cursor: default; }
            .page-item.disabled { opacity: 0.3; cursor: not-allowed; }
            .page-item svg { width: 18px; height: 18px; stroke-width: 2.5px; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('showDeleteConfirmation', (careerId) => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This application will be permanently deleted!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('deleteCareer', careerId);
                        }
                    });
                });

                Livewire.on('message', (message) => {
                    toastr.success(message, 'Success', {
                        timeOut: 3000,
                        progressBar: true,
                    });
                });
            });
        </script>
    @endpush
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Careers Management</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Careers Management</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Applications List</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control search" placeholder="Search by name, email or position..." wire:model.live.debounce.300ms="search">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Applicant</th>
                                            <th>Contact Info</th>
                                            <th>Position</th>
                                            <th>Location</th>
                                            <th>Status</th>
                                            <th>Applied At</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($careers as $career)
                                            <tr wire:key="career-{{ $career->id }}">
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="flex-shrink-0 me-2">
                                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($career->name) }}&background=random" alt="" class="avatar-xs rounded-circle">
                                                        </div>
                                                        <div>
                                                            <h5 class="fs-14 m-0">{{ $career->name }}</h5>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $career->email }}</td>
                                                <td><span class="badge badge-soft-primary">{{ $career->position }}</span></td>
                                                <td>
                                                    @if($career->country || $career->city)
                                                        {{ $career->city }}{{ $career->city && $career->country ? ',' : '' }} {{ $career->country }}
                                                    @else
                                                        <span class="text-muted">N/A</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" wire:click="toggleStatus({{ $career->id }})"{{ $career->status == 1 ? 'checked' : '' }}>
                                                    </div>
                                                </td>
                                                <td>{{ $career->created_at->format('d M, Y') }}</td>
                                                <td>
                                                    <div class="d-flex gap-2">
                                                        <button class="btn btn-sm btn-info" wire:click="openModal({{ $career->id }})" title="View Details">
                                                            <i class="ri-eye-line me-1"></i> Detail
                                                        </button>
                                                        <button class="btn btn-sm btn-danger" wire:click="confirmDelete({{ $career->id }})" title="Delete">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="ri-search-2-line display-5"></i>
                                                        <h5 class="mt-2">No Applications Found</h5>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $careers->links('vendor.pagination.custom') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($showModal && $selectedCareer)
            <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title mb-3">Application Details: {{ $selectedCareer->name }}</h5>
                            <button type="button" class="btn-close mb-3" wire:click="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6 border-end">
                                    <h6 class="text-primary mb-3">Candidate Information</h6>
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                        <tr>
                                            <th class="ps-0" width="30%">Full Name:</th>
                                            <td class="text-muted">{{ $selectedCareer->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Email:</th>
                                            <td class="text-muted">{{ $selectedCareer->email }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Position:</th>
                                            <td class="text-dark fw-bold">{{ $selectedCareer->position }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">CV / Resume:</th>
                                            <td>
                                                @if($selectedCareer->cv)
                                                    <a href="{{ asset($selectedCareer->cv) }}" target="_blank" class="btn btn-sm btn-soft-success">
                                                        <i class="ri-download-cloud-2-line me-1"></i> Download CV
                                                    </a>
                                                @else
                                                    <span class="text-danger">Not Uploaded</span>
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-danger mb-3">System & Location Data</h6>
                                    <table class="table table-sm table-borderless">
                                        <tbody>
                                        <tr>
                                            <th class="ps-0" width="30%">IP Address:</th>
                                            <td><code>{{ $selectedCareer->ip_address ?? 'Unknown' }}</code></td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Country:</th>
                                            <td class="text-muted">{{ $selectedCareer->country ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">City/Region:</th>
                                            <td class="text-muted">
                                                {{ $selectedCareer->city ?? '' }}
                                                {{ $selectedCareer->region ? '('.$selectedCareer->region.')' : '' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Zip Code:</th>
                                            <td class="text-muted">{{ $selectedCareer->zip_code ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th class="ps-0">Coordinates:</th>
                                            <td class="text-muted">
                                                @if($selectedCareer->latitude && $selectedCareer->longitude)
                                                    <a href="https://www.google.com/maps/search/?api=1&query={{ $selectedCareer->latitude }},{{ $selectedCareer->longitude }}" target="_blank">
                                                        {{ $selectedCareer->latitude }}, {{ $selectedCareer->longitude }} <i class="ri-external-link-line ms-1"></i>
                                                    </a>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-12">
                                    <h6 class="text-muted mb-2">Technical Details</h6>
                                    <p class="mb-1"><strong>Referrer:</strong> <span class="text-muted">{{ $selectedCareer->referrer ?? 'Direct' }}</span></p>
                                    <p class="mb-0"><strong>User Agent:</strong> <small class="text-muted">{{ $selectedCareer->user_agent ?? 'N/A' }}</small></p>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" wire:click="closeModal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
