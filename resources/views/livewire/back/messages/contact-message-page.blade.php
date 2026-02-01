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
            .message-preview { max-width: 250px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('showDeleteConfirmation', (id) => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This message will be permanently deleted!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('deleteMessage', id);
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
                            <h4 class="mb-sm-0">Contact Messages</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Messages</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mb-0">Inbox</h4>
                            </div>
                            <div class="card-body">
                                <div class="row g-4 mb-3">
                                    <div class="col-sm">
                                        <div class="d-flex justify-content-sm-end">
                                            <div class="search-box ms-2">
                                                <input type="text" class="form-control search" placeholder="Search name, email, content..." wire:model.live.debounce.300ms="search">
                                                <i class="ri-search-line search-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive table-card mt-3 mb-1">
                                    <table class="table align-middle table-nowrap table-hover">
                                        <thead class="table-light">
                                        <tr>
                                            <th>Sender</th>
                                            <th>Type</th>
                                            <th>Message Preview</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($messages as $msg)
                                            <tr wire:key="msg-{{ $msg->id }}">
                                                <td>
                                                    <div class="d-flex flex-column">
                                                        <span class="fw-medium">{{ $msg->name }}</span>
                                                        <small class="text-muted">{{ $msg->email }}</small>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge badge-soft-info text-uppercase">{{ $msg->type ?? 'General' }}</span>
                                                </td>
                                                <td>
                                                    <div class="message-preview text-muted">
                                                        {{ Str::limit($msg->message, 50) }}
                                                    </div>
                                                </td>
                                                <td>{{ $msg->created_at->format('d M, Y H:i') }}</td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" wire:click="toggleStatus({{ $msg->id }})" {{ $msg->status == 1 ? 'checked' : '' }} title="Mark as Read/Unread">
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="d-flex gap-2 ">
                                                        <button class="btn btn-sm btn-soft-primary" wire:click="openModal({{ $msg->id }})" title="View Message">
                                                            <i class="ri-eye-line"></i> View
                                                        </button>
                                                        <button class="btn btn-sm btn-soft-danger" wire:click="confirmDelete({{ $msg->id }})" title="Delete">
                                                            <i class="ri-delete-bin-line"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-5">
                                                    <div class="text-muted">
                                                        <i class="ri-inbox-archive-line display-5"></i>
                                                        <h5 class="mt-2">No Messages Found</h5>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="mt-3">
                                    {{ $messages->links('vendor.pagination.custom') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if($showModal && $selectedMessage)
            <div class="modal fade show" tabindex="-1" style="display: block; background: rgba(0,0,0,0.5);">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title mb-3">
                                <i class="ri-mail-line me-1"></i> Message Details
                            </h5>
                            <button type="button" class="btn-close mb-3" wire:click="closeModal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-7 border-end">
                                    <div class="mb-4">
                                        <h6 class="text-muted text-uppercase fs-12">Sender Info</h6>
                                        <h5 class="fs-15 mb-1">{{ $selectedMessage->name }}</h5>
                                        <p class="text-primary mb-1">{{ $selectedMessage->email }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6 class="text-muted text-uppercase fs-12">Message Content</h6>
                                        <div class="p-3 bg-light rounded border">
                                            {{ $selectedMessage->message }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <h6 class="text-muted text-uppercase fs-12 mb-3">Technical Details</h6>

                                    <ul class="list-unstyled vstack gap-2 fs-13">
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs text-center me-2">
                                                    <div class="avatar-title bg-soft-info text-info rounded-circle">
                                                        <i class="ri-map-pin-line"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Location</h6>
                                                    <span class="text-muted">
                                                        {{ $selectedMessage->city ?? 'N/A' }}, {{ $selectedMessage->country ?? 'N/A' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs text-center me-2">
                                                    <div class="avatar-title bg-soft-warning text-warning rounded-circle">
                                                        <i class="ri-global-line"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">IP Address</h6>
                                                    <span class="text-muted code">{{ $selectedMessage->ip_address ?? 'Unknown' }}</span>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 avatar-xs text-center me-2">
                                                    <div class="avatar-title bg-soft-success text-success rounded-circle">
                                                        <i class="ri-links-line"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0">Referrer</h6>
                                                    <span class="text-muted">{{ $selectedMessage->referrer ?? 'Direct' }}</span>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    @if($selectedMessage->latitude && $selectedMessage->longitude)
                                        <div class="mt-4">
                                            <a href="https://www.google.com/maps/search/?api=1&query={{ $selectedMessage->latitude }},{{ $selectedMessage->longitude }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary w-100">
                                                <i class="ri-map-2-line me-1"></i> View on Google Maps
                                            </a>
                                        </div>
                                    @endif
                                    <div class="mt-4 pt-3 border-top">
                                        <small class="text-muted">User Agent:</small>
                                        <p class="fs-11 text-muted fst-italic mb-0">
                                            {{ Str::limit($selectedMessage->user_agent, 80) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer bg-light">
                            <button type="button" class="btn btn-secondary mt-3" wire:click="closeModal">Close</button>
                            <a href="mailto:{{ $selectedMessage->email }}" class="btn btn-primary mt-3">
                                <i class="ri-reply-line me-1"></i> Reply via Email
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
