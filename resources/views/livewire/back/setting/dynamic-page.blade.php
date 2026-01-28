<div>
    @push('styles')
        <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <style>
            .ck-editor__editable { min-height: 250px; }
            .nav-link { cursor: pointer; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js"></script>

        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('message', (message) => {
                    toastr.success(message, 'Success', {
                        timeOut: 3000,
                        progressBar: true,
                    });
                });
            });

            function initEditor(elementId, propertyName) {
                // Check if element exists before creating editor to avoid errors
                const element = document.querySelector('#' + elementId);
                if(!element) return;

                ClassicEditor
                    .create(element, {
                        toolbar: ['heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo']
                    })
                    .then(editor => {
                        editor.model.document.on('change:data', () => {
                            // "false" defers the request to prevent tab jumping
                            @this.set(propertyName, editor.getData(), false);
                        });
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }

            // Corrected fields list matching database (term is singular)
            const fields = [
                'privacy_en', 'privacy_tr', 'privacy_ee',
                'term_en', 'term_tr', 'term_ee',
                'license_en', 'license_tr', 'license_ee',
                'compliance_en', 'compliance_tr', 'compliance_ee'
            ];

            // Initialize after a small delay to ensure DOM is ready
            setTimeout(() => {
                fields.forEach(field => initEditor(field, field));
            }, 100);
        </script>
    @endpush

    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Dynamic Pages Management</h4>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title mb-0">Manage Legal & Info Pages</h4>
                                <button type="button" class="btn btn-primary" wire:click="updateContent">
                                    <i class="ri-save-line align-bottom me-1"></i> Update Changes
                                </button>
                            </div>
                            <div class="card-body">
                                <ul class="nav nav-tabs nav-justified mb-3">
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab == 'privacy' ? 'active' : '' }}"
                                           wire:click.prevent="setTab('privacy')">
                                            <i class="ri-shield-user-line me-1"></i> Privacy
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab == 'term' ? 'active' : '' }}"
                                           wire:click.prevent="setTab('term')">
                                            <i class="ri-file-list-3-line me-1"></i> Terms
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab == 'license' ? 'active' : '' }}"
                                           wire:click.prevent="setTab('license')">
                                            <i class="ri-copyright-line me-1"></i> License
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link {{ $activeTab == 'compliance' ? 'active' : '' }}"
                                           wire:click.prevent="setTab('compliance')">
                                            <i class="ri-scales-3-line me-1"></i> Compliance
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content text-muted">
                                    {{--
                                        Note: The key 'term' here corresponds to the database naming convention
                                        and the public properties in your controller ($term_en, etc.)
                                    --}}
                                    @foreach(['privacy', 'term', 'license', 'compliance'] as $key)

                                        <div class="tab-pane {{ $activeTab == $key ? 'active show' : '' }}" id="{{ $key }}" role="tabpanel">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label text-primary">English (EN)</label>
                                                        <div wire:ignore>
                                                            <textarea id="{{ $key }}_en" wire:model="{{ $key }}_en"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label text-danger">Turkish (TR)</label>
                                                        <div wire:ignore>
                                                            <textarea id="{{ $key }}_tr" wire:model="{{ $key }}_tr"></textarea>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label class="form-label text-success">Estonian (EE)</label>
                                                        <div wire:ignore>
                                                            <textarea id="{{ $key }}_ee" wire:model="{{ $key }}_ee"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
