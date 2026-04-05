<div>
    {{-- ============================================================
         Validation Summary
         ============================================================ --}}
    @if ($errors->any())
        <div class="alert alert-danger mb-3">
            <h6 class="mb-1"><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @error('general')
        <div class="alert alert-danger"><i class="fas fa-exclamation-triangle"></i> {{ $message }}</div>
    @enderror

    {{-- ============================================================
         Edit / Create Mode Banner
         ============================================================ --}}
    @if($menuItem)
        <div class="alert alert-info py-2 mb-3">
            <i class="fas fa-edit"></i> Editing: <strong>{{ $menuItem->name }}</strong>
            <small class="d-block text-muted">Created {{ $menuItem->created_at->format('M j, Y') }} · Updated {{ $menuItem->updated_at->diffForHumans() }}</small>
        </div>
    @else
        <div class="alert alert-success py-2 mb-3">
            <i class="fas fa-plus-circle"></i> Creating a new menu item
        </div>
    @endif

    {{-- ============================================================
         SECTION 1 — Link Type (visual cards)
         ============================================================ --}}
    <div class="mb-4">
        <h6 class="text-uppercase text-muted fw-semibold small mb-2">Link Type <span class="text-danger">*</span></h6>
        <div class="row g-2">
            @foreach([
                '2' => ['icon' => 'fas fa-external-link-alt', 'label' => 'External Link',  'hint' => 'Any URL or external site'],
                '1' => ['icon' => 'fas fa-file-alt',          'label' => 'File Link',       'hint' => 'PDF, image, or uploaded file'],
                '3' => ['icon' => 'fas fa-align-left',        'label' => 'Content Page',    'hint' => 'Rich-text inline content'],
            ] as $val => $opt)
                <div class="col-4">
                    <div class="border rounded p-2 text-center cursor-pointer {{ $type == $val ? 'border-primary bg-primary bg-opacity-10' : '' }}"
                         wire:click="$set('type', '{{ $val }}')"
                         style="cursor:pointer; transition: all .15s">
                        <i class="{{ $opt['icon'] }} {{ $type == $val ? 'text-primary' : 'text-muted' }} mb-1" style="font-size:1.2rem"></i>
                        <div class="fw-semibold small {{ $type == $val ? 'text-primary' : '' }}">{{ $opt['label'] }}</div>
                        <div class="text-muted" style="font-size:11px">{{ $opt['hint'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        @error('type') <span class="text-danger small">{{ $message }}</span> @enderror
    </div>

    {{-- ============================================================
         SECTION 2 — Core Fields
         ============================================================ --}}
    <h6 class="text-uppercase text-muted fw-semibold small mb-2">Basic Information</h6>
    <div class="row g-2 mb-3">
        <div class="col-sm-6">
            <label class="form-label small fw-semibold">Language <span class="text-danger">*</span></label>
            <select wire:model="locale" class="form-select">
                <option value="">— Select Language —</option>
                <option value="en">English</option>
                <option value="hi">Hindi</option>
                {{-- <option value="es">Spanish</option>
                <option value="fr">French</option> --}}
            </select>
            @error('locale') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label small fw-semibold">Parent Menu <span class="text-danger">*</span></label>
            <select wire:model.live="menu_id" class="form-select" required>
                <option value="">— Select Menu —</option>
                @foreach($menus as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
            @error('menu_id') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-sm-6">
            <label class="form-label small fw-semibold">Parent Item</label>
            <select wire:model="parent_id" class="form-select" @if(!$menu_id) disabled @endif wire:key="parent-{{ $menu_id }}">
                <option value="">— Root Level (no parent) —</option>
                @if($menu_id)
                    @forelse($parent_items as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                    @empty
                        <option value="" disabled>No parent items available</option>
                    @endforelse
                @else
                    <option value="" disabled>Select a menu first</option>
                @endif
            </select>
            <small class="text-muted" style="font-size:11px">Leave blank for top-level. Select to create a dropdown child.</small>
            @error('parent_id') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="col-sm-6">
            <label class="form-label small fw-semibold">Link Place</label>
            <select wire:model="link_place" class="form-select">
                <option value="">— Select —</option>
                <option value="1">Head Top</option>
                <option value="2">Header</option>
                <option value="3">Nav Bar</option>
                <option value="4">Middle</option>
                <option value="5">None</option>
                <option value="6">Footer Bottom</option>
            </select>
        </div>
    </div>

    <div class="row g-2 mb-3">
        <div class="col-sm-4">
            <label class="form-label small fw-semibold">Display Name <span class="text-danger">*</span></label>
            <input type="text" wire:model.blur="name" class="form-control" placeholder="e.g., Home, About Us" required />
            @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="col-sm-4">
            <label class="form-label small fw-semibold">Slug</label>
            <div class="input-group">
                <input type="text" wire:model="slug" class="form-control" placeholder="auto-generated" />
                <button type="button" wire:click="generateSlug" class="btn btn-outline-secondary" title="Generate from name">
                    <i class="fas fa-magic"></i>
                </button>
            </div>
            @error('slug') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="col-sm-4">
            <label class="form-label small fw-semibold">Sort Order</label>
            <input type="number" wire:model="sort_order" class="form-control" placeholder="0" min="0" />
            <small class="text-muted" style="font-size:11px">Lower numbers appear first.</small>
            @error('sort_order') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
    </div>

    {{-- ============================================================
         SECTION 3 — URL / Content (conditional)
         ============================================================ --}}
    @if($type == '1' || $type == '2')
        <h6 class="text-uppercase text-muted fw-semibold small mb-2 mt-3">Link Settings</h6>
        <div class="row g-2 mb-3">
            <div class="col-sm-8">
                <label class="form-label small fw-semibold">
                    @if($type == '1') File URL @else External URL @endif
                </label>
                <input type="text" wire:model="url" class="form-control"
                       placeholder="{{ $type == '1' ? '/storage/files/document.pdf' : 'https://example.com' }}" />
                @error('url') <span class="text-danger small">{{ $message }}</span> @enderror
            </div>
            <div class="col-sm-4">
                <label class="form-label small fw-semibold">Open In</label>
                <select wire:model="opens_new_tab" class="form-select">
                    <option value="0">Same tab</option>
                    <option value="1">New tab</option>
                </select>
            </div>
        </div>
    @endif

    @if($type == '3')
        <h6 class="text-uppercase text-muted fw-semibold small mb-2 mt-3">Content</h6>
        <div class="mb-3">
            <textarea id="content" wire:model="content" class="form-control" rows="6"
                      placeholder="Enter the content for this page...">{{ $content }}</textarea>
            <small class="text-muted" style="font-size:11px">Rich text editor loads below.</small>
        </div>
    @endif

    {{-- ============================================================
         SECTION 4 — Display Options
         ============================================================ --}}
    <h6 class="text-uppercase text-muted fw-semibold small mb-2 mt-3">Display Options</h6>
    <div class="row g-2 mb-3">
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">Icon Class</label>
            <input type="text" wire:model="icon" class="form-control" placeholder="fas fa-home" />
        </div>
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">Badge Text</label>
            <input type="text" wire:model="badge_text" class="form-control" placeholder="New, Hot…" />
        </div>
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">Badge Color</label>
            <select wire:model="badge_color" class="form-select">
                <option value="">— None —</option>
                <option value="primary">Primary (Blue)</option>
                <option value="success">Success (Green)</option>
                <option value="danger">Danger (Red)</option>
                <option value="warning">Warning (Yellow)</option>
                <option value="info">Info (Cyan)</option>
                <option value="secondary">Secondary (Gray)</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">CSS Classes</label>
            <input type="text" wire:model="css_classes" class="form-control" placeholder="highlighted active" />
        </div>
    </div>

    {{-- ============================================================
         SECTION 5 — Status & Visibility
         ============================================================ --}}
    <h6 class="text-uppercase text-muted fw-semibold small mb-2 mt-3">Status & Visibility</h6>
    <div class="row g-2 mb-3">
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">Status <span class="text-danger">*</span></label>
            <select wire:model="status" class="form-select" required>
                <option value="1">Published</option>
                <option value="0">Disabled</option>
                <option value="2">Draft</option>
            </select>
            @error('status') <span class="text-danger small">{{ $message }}</span> @enderror
        </div>
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">Active</label>
            <select wire:model="is_active" class="form-select">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">Visible</label>
            <select wire:model="is_visible" class="form-select">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="col-sm-3">
            <label class="form-label small fw-semibold">SEO Meta Title</label>
            <input type="text" wire:model="meta_title" class="form-control" placeholder="Page title for SEO" />
        </div>
    </div>

    {{-- ============================================================
         SECTION 6 — Admin Notes (collapsed by default)
         ============================================================ --}}
    <div class="accordion mb-3" id="advancedAccordion">
        <div class="accordion-item border">
            <h2 class="accordion-header">
                <button class="accordion-button collapsed py-2 small fw-semibold" type="button"
                        data-bs-toggle="collapse" data-bs-target="#advancedCollapse">
                    Advanced / Admin Notes
                </button>
            </h2>
            <div id="advancedCollapse" class="accordion-collapse collapse">
                <div class="accordion-body py-3">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Admin Notes</label>
                            <textarea wire:model="note" class="form-control" rows="2"
                                      placeholder="Internal notes (not visible to users)"></textarea>
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Custom Data (JSON)</label>
                            <textarea wire:model="custom_data" class="form-control font-monospace" rows="2"
                                      placeholder='{"priority": "high"}'></textarea>
                            @error('custom_data') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                    <div class="row g-2 mt-1">
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">HTML Attributes (JSON)</label>
                            <textarea wire:model="html_attributes" class="form-control font-monospace" rows="2"
                                      placeholder='{"data-toggle": "tooltip"}'></textarea>
                            @error('html_attributes') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label small fw-semibold">Route Parameters (JSON)</label>
                            <textarea wire:model="route_parameters" class="form-control font-monospace" rows="2"
                                      placeholder='{"id": 1}'></textarea>
                            @error('route_parameters') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ============================================================
         Form Actions
         ============================================================ --}}
    <div class="d-flex align-items-center justify-content-between pt-3 border-top">
        <div class="d-flex gap-2">
            <button type="button" wire:click="save"
                    class="btn {{ $menuItem ? 'btn-primary' : 'btn-success' }}"
                    wire:loading.attr="disabled">
                <span wire:loading.remove>
                    <i class="fas {{ $menuItem ? 'fa-save' : 'fa-plus-circle' }}"></i>
                    {{ $menuItem ? 'Update Menu Item' : 'Create Menu Item' }}
                </span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin"></i> Saving…
                </span>
            </button>

            @if(!$menuItem)
                <button type="button" wire:click="resetForm" class="btn btn-outline-secondary">
                    <i class="fas fa-undo"></i> Reset
                </button>
            @else
                <a href="{{ route('backend.menuitems.show', $menuItem) }}" class="btn btn-outline-info">
                    <i class="fas fa-eye"></i> View
                </a>
            @endif
        </div>

        <div>
            @if($menu_id)
                <a href="{{ route('backend.menus.show', $menu_id) }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i> Cancel
                </a>
            @else
                <a href="{{ route('backend.menuitems.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times-circle"></i> Cancel
                </a>
            @endif
        </div>
    </div>

    {{-- ============================================================
         Summernote (Content type only)
         ============================================================ --}}
    @if($type === '3')
        <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
        <script>
            document.addEventListener('livewire:init', function () {
                function initSummernote() {
                    if ($('#content').length && !$('#content').hasClass('note-codable')) {
                        $('#content').summernote({
                            height: 300,
                            toolbar: [
                                ['style', ['style']],
                                ['font', ['bold', 'italic', 'underline', 'clear']],
                                ['color', ['color']],
                                ['para', ['ul', 'ol', 'paragraph']],
                                ['table', ['table']],
                                ['insert', ['link', 'picture', 'video']],
                                ['view', ['codeview', 'undo', 'redo']],
                            ],
                            callbacks: {
                                onChange: function (contents) {
                                    @this.set('content', contents);
                                }
                            }
                        });
                    }
                }
                setTimeout(initSummernote, 200);
            });
        </script>
    @endif
</div>
