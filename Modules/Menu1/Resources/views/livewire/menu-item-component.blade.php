<div>
    {{-- Validation Summary --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <h6><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- General Errors --}}
    @error('general')
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle"></i> {{ $message }}
        </div>
    @enderror





    {{-- Form Mode Indicator --}}
    @if($menuItem)
        <div class="alert alert-info">
            <i class="fas fa-edit"></i> Editing menu item: <strong>{{ $menuItem->name }}</strong>
            <small class="d-block">Created: {{ $menuItem->created_at->format('M j, Y') }} | Last updated: {{ $menuItem->updated_at->diffForHumans() }}</small>
        </div>
    @else
        <div class="alert alert-success">
            <i class="fas fa-plus-circle"></i> Creating new menu item
        </div>
    @endif

    {{-- Basic Information --}}
    <div class="row">
        <div class="col-sm-6 col-6 mb-3"> 
            <div class="form-group">
                <label for="locale" class="form-label">Language  <span class="text-danger">*</span> </label>
                <select wire:model="locale" class="form-select">
                    <option value="">-- Select Language --</option>
                    <option value="1">English</option>
                    {{-- <option value="es">Spanish</option>
                    <option value="fr">French</option>
                    <option value="de">German</option>
                    <option value="ar">Arabic</option> --}}
                    <option value="2">Hindi</option>
                </select>
                @error("locale")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6 col-6 mb-3">
            <div class="form-group">
                <label for="menu_id" class="form-label">
                    Menu
                    <span class="text-danger">*</span>
                </label>
                <select wire:model.live="menu_id" class="form-select" required>
                    <option value="">-- Select Menu --</option>
                    @foreach ($menus as $id => $name)
                        <option value="{{ $id }}">{{ $name }}</option>
                
                    @endforeach
                </select>
                @error("menu_id")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>  
    <div class="row">



       
        <div class="col-sm-6 col-6 mb-3">
            <div class="form-group">
                <label for="parent_id" class="form-label">Parent Item</label>
                <select wire:model="parent_id" class="form-select" wire:key="parent-{{ $menu_id }}" @if(!$menu_id) disabled @endif>
                    <option value="">-- No Parent (Root Level) --</option>
                    @if($menu_id)
                        @forelse ($parent_items as $id => $name)
                            <option value="{{ $id }}">{{ $name }}</option>
                        @empty
                            <option value="" disabled>No parent items available</option>
                        @endforelse
                    @else
                        <option value="" disabled>Select a menu first</option>
                    @endif
                </select>
                <small class="form-text text-muted">
                    @if($menu_id)
                        Select parent item to create dropdown menu
                    @else
                        Select a menu first to see available parent items
                    @endif
                </small>
                @error("parent_id")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6 col-6 mb-3">
            <div class="form-group">
                <label for="type" class="form-label">
                    Link Type
                    <span class="text-danger">*</span>
                </label>
                <select wire:model.live="type" class="form-select" required>
                    <option value="">-- Select Type --</option>
                    {{-- <option value="link">Link</option> --}}
                    {{-- <option value="dropdown">Dropdown</option>
                    <option value="divider">Divider</option>
                    <option value="heading">Heading</option> --}}
                     <option value="1">File Link</option>
                    <option value="2">External Link</option>
                    <option value="3">Content Link</option>
                    
                </select>
                @error("type")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

</div>

    <div class="row">
        <div class="col-sm-4 col-12 mb-3">
            <div class="form-group">
                <label for="name" class="form-label">
                    Display Name
                    <span class="text-danger">*</span>
                </label>
                <input
                    type="text"
                    wire:model.blur="name"
                    class="form-control"
                    placeholder="e.g., Home, About Us, Contact"
                    required
                />
                @error("name")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-4 col-12 mb-3">
            <div class="form-group">
                <label for="slug" class="form-label">Slug</label>
                <div class="input-group">
                    <input type="text" wire:model="slug" class="form-control" placeholder="e.g., home, about-us, contact" />
                    <button type="button" wire:click="generateSlug" class="btn btn-outline-secondary" title="Generate from name">
                        <i class="fas fa-magic"></i>
                    </button>
                </div>
                @error("slug")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                <small class="form-text text-muted">Auto-generated from name if left empty</small>
            </div>
        </div>
        <div class="col-sm-4 col-12 mb-3">
            <div class="form-group">
                <label for="sort_order" class="form-label">Sort Order</label>
                <input type="number" wire:model="sort_order" class="form-control" placeholder="0" min="0" />
                <small class="form-text text-muted">Lower numbers appear first</small>
                @error("sort_order")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

 
@if($menu_id == 4 ) 


 <div class="row">
 <!-- Link Place -->
    <div class="col-sm-6 col-6 mb-3">
        <label class="form-label">Link Place</label>
        <select wire:model="link_place" class="form-control">
            <option value="-1">Select</option>
            <option value="1">HeadTop</option>
            <option value="2">Header</option>
            <option value="3">Nav Bar</option>
            <option value="4">Middle</option>
            <option value="5">None</option>
            <option value="6">Footer Bottom</option>
            
        </select>
    </div>

      <!-- Link Position -->
    <div class="col-sm-6 col-6 mb-3">
        <label class="form-label">Link Position</label>
        <input type="number" wire:model="link_position" class="form-control">
    </div>
 </div>
<div class="row">
    <!-- Set as TopLink -->
    <div class="col-sm-3 col-12 mb-3">
        <label class="form-label">Set as TopLink</label>
        <div>
            <input type="checkbox" wire:model.live="is_top">
        </div>
    </div>  

    <!-- TopLink Position -->
    <div class="col-sm-3 col-12 mb-3">
        <label class="form-label">TopLink Position</label>
        <input 
            type="number" 
            wire:model="top_position" 
            class="form-control"
            {{ !$is_top ? 'disabled' : '' }}
        >
    </div>
</div>

  

 

@endif



    

    {{-- Link Type Specific Fields --}}

    {{-- TYPE 1: File Link --}}
    @if($type === "1")
        <div class="row">
            <div class="col-12 mb-3">
                <h5><i class="fas fa-file"></i> File Link Settings</h5>
            </div>

            <!-- Upload File -->
            <div class="col-sm-6 col-12 mb-3">
                <div class="form-group">
                    <label for="file" class="form-label">
                        Upload File <span class="text-danger">*</span>
                    </label>
                    <input
                        type="file"
                        wire:model="file"
                        class="form-control"
                        accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx"
                    />
                    <small class="text-muted">
                        Allowed: PDF, DOC, DOCX, XLS, XLSX, JPG, PNG (Max: 15MB)
                    </small>
                    @error("file")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>
    @endif

    {{-- TYPE 3: Content Link --}}
    @if($type === "3")
        <div class="row">
            <div class="col-12 mb-3">
                <h5><i class="fas fa-file-alt"></i> Content Link Settings</h5>
            </div>

            <!-- Header Image -->
            <div class="col-sm-6 col-12 mb-3">
                <div class="form-group">
                    <label for="header_image" class="form-label">
                        Header Image
                    </label>
                    <input
                        type="file"
                        wire:model="header_image"
                        class="form-control"
                        accept=".jpg,.jpeg,.png"
                    />
                    <small class="text-muted">
                        Recommended size: 1600 x 154 px
                    </small>
                    @error("header_image")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Source/Author -->
            <div class="col-sm-6 col-12 mb-3">
                <div class="form-group">
                    <label for="source" class="form-label">Source/Author</label>
                    <textarea
                        wire:model="source"
                        class="form-control"
                        rows="2"
                        placeholder="Enter source or author information"
                    ></textarea>
                    @error("source")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Meta Description -->
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea
                        wire:model="meta_description"
                        class="form-control"
                        rows="2"
                        placeholder="Brief description for SEO"
                    ></textarea>
                    @error("meta_description")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-12 mb-3">
                <div class="form-group">
                    <label for="content" class="form-label">
                        Content <span class="text-danger">*</span>
                    </label>
                    <textarea
                        wire:model="content"
                        id="content"
                        class="form-control"
                        rows="8"
                        placeholder="Enter the main content"
                    ></textarea>
                    @error("content")
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Set as Main Link -->
            <div class="col-sm-6 col-12 mb-3">
                <div class="form-group">
                    <label class="form-label">Set as Main Link</label>
                    <div>
                        <input type="checkbox" wire:model="is_main"> Featured Content
                    </div>
                </div>
            </div>

            <!-- Open in New Tab -->
            <div class="col-sm-6 col-12 mb-3">
                <div class="form-group">
                    <label for="opens_new_tab" class="form-label">Open in New Tab</label>
                    <select wire:model="opens_new_tab" class="form-select">
                        <option value="0">No</option>
                        <option value="1">Yes</option>
                    </select>
                </div>
            </div>
        </div>
    @endif

    {{-- Display Properties --}}
    <div class="row">
        <div class="col-12 mb-3">
            <h5>Display Properties</h5>
    </div>
        <div class="col-sm-3 col-12 mb-3">
            <div class="form-group">
                <label for="icon" class="form-label">Icon Class</label>
                <input type="text" wire:model="icon" class="form-control" placeholder="e.g., fas fa-home" />
                <small class="form-text text-muted">FontAwesome or similar icon class</small>
                @error("icon")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3 col-12 mb-3">
            <div class="form-group">
                <label for="badge_text" class="form-label">Badge Text</label>
                <input type="text" wire:model="badge_text" class="form-control" placeholder="New, Hot, 5" />
                @error("badge_text")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3 col-12 mb-3">
            <div class="form-group">
                <label for="badge_color" class="form-label">Badge Color</label>
                <select wire:model="badge_color" class="form-select">
                    <option value="">-- Select Color --</option>
                    <option value="primary">Primary</option>
                    <option value="secondary">Secondary</option>
                    <option value="success">Success</option>
                    <option value="danger">Danger</option>
                    <option value="warning">Warning</option>
                    <option value="info">Info</option>
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>
                @error("badge_color")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3 col-12 mb-3">
            <div class="form-group">
                <label for="opens_new_tab" class="form-label">Open in New Tab</label>
                <select wire:model="opens_new_tab" class="form-select" id="opens_new_tab">
                    <option value="0">No</option>
                    <option value="1">Yes</option>
                </select>
                @error("opens_new_tab")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6 col-12 mb-3">
            <div class="form-group">
                <label for="css_classes" class="form-label">CSS Classes</label>
                <input
                    type="text"
                    wire:model="css_classes"
                    class="form-control"
                    placeholder="nav-item active highlighted"
                />
                @error("css_classes")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6 col-12 mb-3">
            <div class="form-group">
                <label for="html_attributes" class="form-label">HTML Attributes (JSON)</label>
                <textarea
                    wire:model="html_attributes"
                    class="form-control"
                    rows="2"
                    placeholder='{"data-toggle": "tooltip", "title": "Click me"}'
                ></textarea>
                <small class="form-text text-muted">Custom HTML attributes in JSON format</small>
                @error("html_attributes")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- Access Control --}}
    
    {{-- <div class="row">
        <div class="col-12 mb-3">
            <h5>Access Control</h5>
        </div>
        <div class="col-sm-6 col-12 mb-3">
            <div class="form-group">
                <label for="permissions" class="form-label">Required Permissions</label>
                <select wire:model="permissions" class="form-select" multiple>
                    @foreach ($available_permissions as $permission => $name)
                        <option value="{{ $permission }}">{{ $name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Users must have these permissions</small>
                @error("permissions")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6 col-12 mb-3">
            <div class="form-group">
                <label for="roles" class="form-label">Required Roles</label>
                <select wire:model="roles" class="form-select" multiple>
                    @foreach ($available_roles as $role => $name)
                        <option value="{{ $role }}">{{ $name }}</option>
                    @endforeach
                </select>
                <small class="form-text text-muted">Users must have one of these roles</small>
                @error("roles")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div> --}}

    {{-- Status & Visibility --}}
    <div class="row">
        <div class="col-12 mb-3">
            <h5>Status & Visibility</h5>
        </div>
        <div class="col-sm-3 col-12 mb-3">
            <div class="form-group">
                <label for="status" class="form-label">
                    Status
                    <span class="text-danger">*</span>
                </label>
                <select wire:model="status" class="form-select" required>
                    <option value="">-- Select Status --</option>
                    <option value="1">Published</option>
                    <option value="0">Disabled</option>
                    <option value="2">Draft</option>
                </select>
                @error("status")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3 col-12 mb-3">
            <div class="form-group">
                <label for="is_active" class="form-label">Active</label>
                <select wire:model="is_active" class="form-select" id="is_active">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @error("is_active")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-3 col-12 mb-3">
            <div class="form-group">
                <label for="is_visible" class="form-label">Visible</label>
                <select wire:model="is_visible" class="form-select" id="is_visible">
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
                @error("is_visible")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
    </div>

    {{-- SEO Fields --}}
    <div class="row">
        <div class="col-12 mb-3">
            <h5>SEO (Optional)</h5>
        </div>
        <div class="col-sm-4 col-12 mb-3">
            <div class="form-group">
                <label for="meta_title" class="form-label">Meta Title</label>
                <input type="text" wire:model="meta_title" class="form-control" placeholder="Page title for SEO" />
                @error("meta_title")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>

    </div>

    {{-- Additional Data & Notes --}}
    <div class="row">
        <div class="col-sm-6 col-12 mb-3">
            <div class="form-group">
                <label for="custom_data" class="form-label">Custom Data (JSON)</label>
                <textarea
                    wire:model="custom_data"
                    class="form-control"
                    rows="3"
                    placeholder='{"priority": "high", "category": "main"}'
                ></textarea>
                <small class="form-text text-muted">Store additional custom properties in JSON format</small>
                @error("custom_data")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-sm-6 col-12 mb-3">
            <div class="form-group">
                <label for="note" class="form-label">Admin Notes</label>
                <textarea
                    wire:model="note"
                    class="form-control"
                    rows="3"
                    placeholder="Internal notes for administrators"
                ></textarea>
                @error("note")
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    {{-- Form Actions --}}
    <div class="row mt-4">
        <div class="col-8">
            <button
                type="button"
                wire:click="save"
                class="btn {{ $menuItem ? "btn-primary" : "btn-success" }}"
                wire:loading.attr="disabled"
            >
                <span wire:loading.remove>
                    <i class="fas {{ $menuItem ? "fa-save" : "fa-plus-circle" }}"></i>
                    {{ $menuItem ? "Update" : "Create" }} Menu Item
                </span>
                <span wire:loading>
                    <i class="fas fa-spinner fa-spin"></i>
                    Saving...
                </span>
            </button>
            
            @if(!$menuItem)
                <button type="button" wire:click="resetForm" class="btn btn-outline-secondary ms-2">
                    <i class="fas fa-undo"></i> Reset Form
                </button>
            @endif
            
            @if($menuItem)
                <a href="{{ route('backend.menuitems.show', $menuItem) }}" class="btn btn-info ms-2">
                    <i class="fas fa-eye"></i> View
                </a>
            @endif
        </div>
        <div class="col-4">
            <div class="float-end">
                @if($menu_id)
                    <a href="{{ route('backend.menus.show', $menu_id) }}" class="btn btn-secondary">
                        <i class="fas fa-times-circle"></i>
                        Cancel
                    </a>
                @else 
                    <a href="{{ route('backend.menuitems.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times-circle"></i>
                        Cancel
                    </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Summernote Editor for Type 3 (Content Link) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>

    <script type="module">
        // Define function to open filemanager window
        var lfm = function (options, cb) {
            var route_prefix = options && options.prefix ? options.prefix : '/laravel-filemanager';
            window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
            window.SetUrl = cb;
        };

        // Define LFM summernote button
        var LFMButton = function (context) {
            var ui = $.summernote.ui;
            var button = ui.button({
                contents: '<i class="note-icon-picture"></i> ',
                tooltip: 'Insert image with filemanager',
                click: function () {
                    lfm(
                        {
                            type: 'image',
                            prefix: '/laravel-filemanager',
                        },
                        function (lfmItems, path) {
                            lfmItems.forEach(function (lfmItem) {
                                context.invoke('insertImage', lfmItem.url);
                            });
                        },
                    );
                },
            });
            return button.render();
        };

        // Initialize Summernote only when type is "3" (Content Link)
        document.addEventListener('livewire:init', function () {
            function initializeSummernote() {
                var contentElement = document.getElementById('content');
                if (contentElement && !$('#content').hasClass('note-codable')) {
                    $('#content').summernote({
                        height: 300,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['fontname', 'fontsize', 'bold', 'italic', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'lfm', 'video']],
                            ['view', ['codeview', 'undo', 'redo', 'help']],
                        ],
                        buttons: {
                            lfm: LFMButton,
                        },
                    });
                }
            }

            // Initialize on page load if type is 3
            @if($type === '3')
                setTimeout(initializeSummernote, 100);
            @endif

            // Re-initialize when content updates
            Livewire.hook('morph.updated', ({ el, component }) => {
                @if($type === '3')
                    if (!$('#content').hasClass('note-codable')) {
                        initializeSummernote();
                    }
                @endif
            });
        });
    </script>
</div>
