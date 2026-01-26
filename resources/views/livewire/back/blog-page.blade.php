<div>
    @push('styles')
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
        <style>
            .pagination { display: flex; padding-left: 0; list-style: none; border-radius: 0.375rem; }
            .page-item.active .page-link { z-index: 3; color: #fff; background-color: #405189; border-color: #405189; }
            .page-link { position: relative; display: block; color: #405189; text-decoration: none; background-color: #fff; border: 1px solid #dee2e6; padding: 0.375rem 0.75rem; margin-left: -1px; }
            .page-link:hover { z-index: 2; color: #405189; background-color: #e9ecef; border-color: #dee2e6; }
            .form-switch .form-check-input { width: 2.5em; height: 1.25em; cursor: pointer; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script>
            document.addEventListener('livewire:initialized', () => {
                // Listen for delete confirmation request
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
                            // Call the specific delete method in your controller
                            @this.call('deleteBlog', blogId);
                        }
                    });
                });

                // Listen for any generic success messages
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
                                <button class="btn btn-success" wire:click="openAddModal">
                                    <i class="ri-add-line align-bottom me-1"></i> Add New Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body">
                        <div class="row g-4 mb-3">
                            <div class="col-sm">
                                <div class="search-box">
                                    <input type="text" class="form-control" placeholder="Search by title or category..." wire:model.live.debounce.300ms="search">
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive table-card">
                            <table class="table align-middle table-nowrap">
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
                            {{ $blogs->links() }}
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
                                                <label class="form-label">Title ({{ $key }}) *</label>
                                                <input type="text" class="form-control" wire:model="title_{{ $key }}" placeholder="Enter title">
                                                @error("title_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Excerpt ({{ $key }})</label>
                                                <textarea class="form-control" wire:model="excerpt_{{ $key }}" rows="2" placeholder="Brief summary..."></textarea>
                                                @error("excerpt_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Body ({{ $key }}) *</label>
                                                <textarea class="form-control" wire:model="body_{{ $key }}" rows="6" placeholder="Main content..."></textarea>
                                                @error("body_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Category ({{ $key }})</label>
                                                <input type="text" class="form-control" wire:model="category_{{ $key }}" placeholder="Category name">
                                                @error("category_$key") <span class="text-danger small">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <hr class="my-4">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Post Image</label>
                                            <input type="file" class="form-control" wire:model="image" id="upload{{ $iteration ?? '' }}">
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
                                            <label class="form-label">Published At</label>
                                            <input type="datetime-local" class="form-control" wire:model="published_at">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Resource (Source Link)</label>
                                            <input type="text" class="form-control" wire:model="resource" placeholder="https://...">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select class="form-select" wire:model="status">
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
