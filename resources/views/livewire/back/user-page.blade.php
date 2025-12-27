<div>
    @push('styles')
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            /* Livewire Pagination Styles */
            .pagination {
                display: flex;
                padding-left: 0;
                list-style: none;
                border-radius: 0.375rem;
            }
            .page-item.active .page-link {
                z-index: 3;
                color: #fff;
                background-color: #405189;
                border-color: #405189;
            }
            .page-link {
                position: relative;
                display: block;
                color: #405189;
                text-decoration: none;
                background-color: #fff;
                border: 1px solid #dee2e6;
                padding: 0.375rem 0.75rem;
                margin-left: -1px;
            }
            .page-link:hover {
                z-index: 2;
                color: #405189;
                background-color: #e9ecef;
                border-color: #dee2e6;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script>
            $(function (){
                $(document).on('click', '#delete', function (e) {
                    e.preventDefault();
                    var link = $(this).attr("href");

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Should this data be deleted?',
                        icon: 'warning',
                        showCancelButton: true,
                        showDenyButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Delete!',
                        cancelButtonText: 'Cancel',
                    }).then((result)=> {
                        if (result.isConfirmed) {
                            window.location.href = link
                            Swal.fire(
                                'Deleted!',
                                'Your file will be deleted.',
                                'success'
                            )
                        }
                    })
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
                                <h4 class="mb-sm-0">Users Management</h4>
                                <div class="page-title-right">
                                    <ol class="breadcrumb m-0">
                                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                        <li class="breadcrumb-item active">Users Management</li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if (session()->has('message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title mb-0">User List</h4>
                                </div>

                                <div class="card-body">
                                    <div id="customerList">
                                        <div class="row g-4 mb-3">
                                            <div class="col-sm-auto">
                                                <div>
                                                    <button type="button" class="btn btn-success add-btn" wire:click="openAddModal">
                                                        <i class="ri-add-line align-bottom me-1"></i> Add User
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="col-sm">
                                                <div class="d-flex justify-content-sm-end">
                                                    <div class="search-box ms-2">
                                                        <input type="text" class="form-control search" placeholder="Search by name or email..." wire:model.live.debounce.300ms="search">
                                                        <i class="ri-search-line search-icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive table-card mt-3 mb-1">
                                            <table class="table align-middle table-nowrap" id="customerTable">
                                                <thead class="table-light">
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Airport</th>
                                                    <th>Location</th>
                                                    <th>Status</th>
                                                    <th>Last Login</th>
                                                    <th>Actions</th>
                                                </tr>
                                                </thead>
                                                <tbody class="list form-check-all">
                                                @forelse($users as $user)
                                                    <tr>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->email }}</td>
                                                        <td>{{ $user->phone ?? 'N/A' }}</td>
                                                        <td>{{ $user->airport ?? 'N/A' }}</td>
                                                        <td>
                                                            @if($user->lat && $user->lon)
                                                                {{ number_format($user->lat, 4) }}, {{ number_format($user->lon, 4) }}
                                                            @else
                                                                N/A
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <span class="badge badge-soft-{{ $user->status == 1 ? 'success' : 'danger' }} text-uppercase">
                                                                {!! $user->status == 1 ? 'Active' : 'Inactive' !!}
                                                            </span>
                                                        </td>
                                                        <td>{{ $user->last_login ? $user->last_login->format('d M, Y') : 'Never' }}</td>
                                                        <td>
                                                            <div class="d-flex gap-2">
                                                                <div class="edit">
                                                                    <button class="btn btn-sm btn-success edit-item-btn"
                                                                            wire:click="openEditModal({{ $user->id }})">
                                                                        Edit
                                                                    </button>
                                                                </div>
                                                                <div class="remove">
                                                                    <button class="btn btn-sm btn-danger remove-item-btn delete"
                                                                            onclick="confirmDelete({{ $user->id }})">
                                                                        Remove
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="text-center">
                                                            <!-- No results content -->
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="d-flex justify-content-end mt-3">
                                            {{ $users->links() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add/Edit Modal -->
            @if($showModal)
                <div class="modal fade show" tabindex="-1" aria-labelledby="userModalLabel" aria-modal="true" role="dialog" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="userModalLabel">{{ $modalTitle }}</h5>
                                <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                            </div>
                            <form wire:submit.prevent="saveUser">
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" id="name" class="form-control" wire:model="name" placeholder="Enter full name">
                                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" id="email" class="form-control" wire:model="email" placeholder="Enter email">
                                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="text" id="phone" class="form-control" wire:model="phone" placeholder="Enter phone number">
                                                @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">
                                                    Password
                                                    @if(!$editingUserId)
                                                        <span class="text-danger">*</span>
                                                    @else
                                                        <small class="text-muted">(Leave blank to keep current)</small>
                                                    @endif
                                                </label>
                                                <input type="password" id="password" class="form-control" wire:model="password" placeholder="Enter password">
                                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                                <select id="" class="form-select" wire:model="status">
                                                    <option value="1">Active</option>
                                                    <option value="0">Inactive</option>
                                                </select>
                                                @error('status') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="mb-3">
                                                <label for="airport" class="form-label">Airport</label>
                                                <input type="text" id="airport" class="form-control" wire:model="airport" placeholder="Enter airport name/code">
                                                @error('airport') <span class="text-danger">{{ $message }}</span> @enderror
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="lat" class="form-label">Latitude</label>
                                                        <input type="number" step="any" id="lat" class="form-control" wire:model="lat" placeholder="e.g., 40.7128">
                                                        @error('lat') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="lon" class="form-label">Longitude</label>
                                                        <input type="number" step="any" id="lon" class="form-control" wire:model="lon" placeholder="e.g., -74.0060">
                                                        @error('lon') <span class="text-danger">{{ $message }}</span> @enderror
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="password_confirmation" class="form-label">
                                                        Confirm Password
                                                        @if(!$editingUserId)
                                                            <span class="text-danger">*</span>
                                                        @endif
                                                    </label>
                                                    <input type="password" id="password_confirmation" class="form-control" wire:model="password_confirmation" placeholder="Confirm password">
                                                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                                </div>
                                            </div>


                                            @if($editingUserId)
                                                <div class="alert alert-info">
                                                    <i class="ri-information-line me-1"></i>
                                                    <small>Leave password fields blank if you don't want to change the password.</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" wire:click="closeModal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">
                                        {{ $editingUserId ? 'Update User' : 'Create User' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-backdrop fade show"></div>
            @endif
        </div>
</div>
