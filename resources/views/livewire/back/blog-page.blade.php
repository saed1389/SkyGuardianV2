<div>
    @push('styles')
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
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
                Livewire.on('showDeleteConfirmation', (blogId) => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This blog post will be permanently deleted!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('deleteBlog', blogId);
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
                            <h4 class="mb-sm-0">Blog Management</h4>
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Blog Management</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
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
                                                    <i class="ri-add-line align-bottom me-1"></i> Add New Post
                                                </button>
                                            </div>
                                        </div>

                                        <div class="col-sm">
                                            <div class="d-flex justify-content-sm-end">
                                                <div class="search-box ms-2">
                                                    <input type="text" class="form-control search" placeholder="Search by title or category..." wire:model.live.debounce.300ms="search">
                                                    <i class="ri-search-line search-icon"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive table-card mt-3 mb-1">
                                        <table class="table align-middle table-nowrap" id="customerTable">
                                            <thead class="table-light">
                                            <tr>
                                                <th>Image</th>
                                                <th>Title (EN)</th>
                                                <th>Category (EN)</th>
                                                <th>Status</th>
                                                <th>Created At</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($blogs as $blog)
                                                <tr wire:key="blog-{{ $blog->id }}">
                                                    <td>
                                                        @if($blog->image)
                                                            <img src="{{ asset($blog->image) }}" width="45" height="45" class="rounded object-cover" alt="">
                                                        @else
                                                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width:45px; height:45px;">
                                                                <i class="ri-image-line text-muted"></i>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>{{ Str::limit($blog->title_en, 40) }}</td>
                                                    <td><span class="badge bg-soft-primary text-primary">{{ $blog->category_en }}</span></td>
                                                    <td>
                                                        <div class="form-check form-switch">
                                                            <input class="form-check-input" type="checkbox" role="switch"
                                                                   wire:change="toggleStatus({{ $blog->id }})"
                                                                {{ $blog->status == 1 ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>{{ $blog->created_at ? $blog->created_at->format('d M, Y') : 'N/A' }}</td>
                                                    <td>
                                                        <div class="d-flex gap-2">
                                                            <button class="btn btn-sm btn-soft-info" wire:click="openEditModal({{ $blog->id }})" title="Edit">
                                                                <i class="ri-edit-line"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-soft-danger" wire:click="confirmDelete({{ $blog->id }})" title="Delete">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center py-4">No blog posts found.</td>
                                                </tr>
                                            @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="mt-3">
                                        {{ $blogs->links('vendor.pagination.custom') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($showModal)
            <div class="modal fade show" style="display:block; background: rgba(0,0,0,0.5); z-index: 1055;" tabindex="-1">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content border-0">
                        <div class="modal-header bg-soft-info p-3">
                            <h5 class="modal-title">{{ $modalTitle }}</h5>
                            <button type="button" class="btn-close" wire:click="closeModal"></button>
                        </div>
                        <form wire:submit.prevent="saveBlog">
                            <div class="modal-body">
                                <div class="row">
                                    @foreach(['en' => 'English', 'tr' => 'Turkish', 'ee' => 'Estonian'] as $key => $label)
                                        <div class="col-lg-4 {{ !$loop->last ? 'border-end' : '' }}">
                                            <h6 class="text-primary mb-3"><i class="ri-global-line me-1"></i> {{ $label }} Content</h6>
                                            <div class="mb-3">
                                                <label class="form-label">Title ({{ $key }}) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="title_{{ $key }}" placeholder="Enter title" required>
                                                @error("title_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Excerpt ({{ $key }}) <span class="text-danger">*</span></label>
                                                <textarea class="form-control" wire:model="excerpt_{{ $key }}" rows="2" placeholder="Brief summary..." required></textarea>
                                                @error("excerpt_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Body ({{ $key }}) <span class="text-danger">*</span></label>
                                                <textarea class="form-control" wire:model="body_{{ $key }}" rows="6" placeholder="Main content..." required></textarea>
                                                @error("body_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Category ({{ $key }}) <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" wire:model="category_{{ $key }}" placeholder="Category name" required>
                                                @error("category_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="my-4">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Post Image <span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" wire:model="image" id="upload{{ $iteration ?? '' }}" >
                                            <div wire:loading wire:target="image" class="text-primary small mt-1">Uploading...</div>

                                            <div class="mt-2">
                                                @if($image)
                                                    <img src="{{ $image->temporaryUrl() }}" class="img-thumbnail" width="150" alt="Preview">
                                                @elseif($existingImage)
                                                    <img src="{{ asset($existingImage) }}" class="img-thumbnail" width="150" alt="Current">
                                                @endif
                                            </div>
                                            @error('image') <span class="text-danger small">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Published At <span class="text-danger">*</span></label>
                                            <input type="datetime-local" class="form-control" wire:model="published_at" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Resource (Source Link) <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" wire:model="resource" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select" wire:model="status" required>
                                                <option value="1">Active / Published</option>
                                                <option value="0">Inactive / Draft</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer bg-light">
                                <button type="button" class="btn btn-ghost-danger" wire:click="closeModal">Discard</button>
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="saveBlog">Save Post</span>
                                    <span wire:loading wire:target="saveBlog">Saving...</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
