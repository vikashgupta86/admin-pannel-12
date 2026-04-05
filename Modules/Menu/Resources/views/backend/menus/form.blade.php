{{-- ================================================================
     Menu Form — Basic Information
     ================================================================ --}}
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Menu Name', 'name')->class('form-label fw-semibold') }}
            <span class="text-danger">*</span>
            {{ html()->text('name')->placeholder('e.g., Header Menu, Footer Menu')->class('form-control')->required() }}
            <small class="form-text text-muted">A human-friendly label for this menu group.</small>
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Slug', 'slug')->class('form-label fw-semibold') }}
            {{ html()->text('slug')->placeholder('e.g., header-menu')->class('form-control') }}
            <small class="form-text text-muted">Auto-generated if left blank.</small>
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Location', 'location')->class('form-label fw-semibold') }}
            <span class="text-danger">*</span>
            {{
                html()->select('location', [
                    'admin-sidebar' => 'Admin Sidebar',
                    'frontend'      => 'Frontend',
                ])->placeholder('— Select location —')->class('form-select')->required()
            }}
            <small class="form-text text-muted">Where this menu will be rendered.</small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            {{ html()->label('Description', 'description')->class('form-label fw-semibold') }}
            {{ html()->textarea('description')->placeholder('Brief description of this menu\'s purpose')->class('form-control')->rows(3) }}
        </div>
    </div>
    <div class="col-12 col-sm-6 mb-3">
        <div class="form-group">
            {{ html()->label('Admin Notes', 'note')->class('form-label fw-semibold') }}
            {{ html()->textarea('note')->placeholder('Internal notes (not shown to users)')->class('form-control')->rows(3) }}
        </div>
    </div>
</div>

{{-- ================================================================
     Display & Theme
     ================================================================ --}}
<hr>
<h6 class="text-muted text-uppercase small fw-semibold mb-3">Display & Theme</h6>
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Theme', 'theme')->class('form-label fw-semibold') }}
            {{
                html()->select('theme', [
                    'default'   => 'Default',
                    'bootstrap' => 'Bootstrap',
                    'minimal'   => 'Minimal',
                    'dark'      => 'Dark Theme',
                    'custom'    => 'Custom',
                ])->class('form-select')
            }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('CSS Classes', 'css_classes')->class('form-label fw-semibold') }}
            {{ html()->text('css_classes')->placeholder('e.g., navbar navbar-expand-lg')->class('form-control') }}
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Language', 'locale')->class('form-label fw-semibold') }}
            {{
                html()->select('locale', [
                    'en' => 'English',
                    'hi' => 'Hindi',
                    'es' => 'Spanish',
                    'fr' => 'French',
                    'de' => 'German',
                    'ar' => 'Arabic',
                ])->placeholder('— All Languages —')->class('form-select')
            }}
            <small class="form-text text-muted">Leave blank to show for all locales.</small>
        </div>
    </div>
</div>

{{-- ================================================================
     Access Control
     ================================================================ --}}
<hr>
<h6 class="text-muted text-uppercase small fw-semibold mb-3">Access Control</h6>
<div class="row">
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Public Access', 'is_public')->class('form-label fw-semibold') }}
            {{
                html()->select('is_public', [
                    '1' => 'Yes — Guests can see this menu',
                    '0' => 'No — Requires authentication',
                ])->placeholder('— Select —')->class('form-select')
            }}
            <small class="form-text text-muted">Controls whether unauthenticated users see this menu.</small>
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Required Permissions', 'permissions[]')->class('form-label fw-semibold') }}
            {{
                html()->select('permissions[]', [
                    'view_backend'    => 'View Backend',
                    'edit_content'    => 'Edit Content',
                    'manage_users'    => 'Manage Users',
                    'manage_settings' => 'Manage Settings',
                ])->class('form-select select2-permissions')->multiple()
            }}
            <small class="form-text text-muted">User needs <em>any one</em> of these permissions.</small>
        </div>
    </div>
    <div class="col-12 col-sm-4 mb-3">
        <div class="form-group">
            {{ html()->label('Required Roles', 'roles[]')->class('form-label fw-semibold') }}
            {{
                html()->select('roles[]', [
                    'super admin' => 'Super Admin',
                    'admin'       => 'Admin',
                    'editor'      => 'Editor',
                    'user'        => 'User',
                ])->class('form-select select2-roles')->multiple()
            }}
            <small class="form-text text-muted">User needs <em>any one</em> of these roles.</small>
        </div>
    </div>
</div>

{{-- ================================================================
     Status & Visibility
     ================================================================ --}}
<hr>
<h6 class="text-muted text-uppercase small fw-semibold mb-3">Status & Visibility</h6>
<div class="row">
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            {{ html()->label('Status', 'status')->class('form-label fw-semibold') }}
            <span class="text-danger">*</span>
            {{
                html()->select('status', [
                    '1' => 'Published',
                    '0' => 'Disabled',
                    '2' => 'Draft',
                ])->class('form-select')->required()
            }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            {{ html()->label('Active', 'is_active')->class('form-label fw-semibold') }}
            {{
                html()->select('is_active', [
                    '1' => 'Yes',
                    '0' => 'No',
                ])->placeholder('— Select —')->class('form-select')
            }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            {{ html()->label('Visible', 'is_visible')->class('form-label fw-semibold') }}
            {{
                html()->select('is_visible', [
                    '1' => 'Yes',
                    '0' => 'No',
                ])->placeholder('— Select —')->class('form-select')
            }}
        </div>
    </div>
    <div class="col-12 col-sm-3 mb-3">
        <div class="form-group">
            {{ html()->label('Max Depth', 'settings[max_depth]')->class('form-label fw-semibold') }}
            {{ html()->number('settings[max_depth]')->placeholder('3')->class('form-control')->attributes(['min' => '1', 'max' => '10']) }}
            <small class="form-text text-muted">Max nesting levels (1–10).</small>
        </div>
    </div>
</div>

<x-library.select2 />
