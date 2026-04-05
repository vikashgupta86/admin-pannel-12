@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item route='{{route("backend.$module_name.index")}}' icon='{{ $module_icon }}'>
        {{ __($module_title) }}
    </x-backend.breadcrumb-item>
    <x-backend.breadcrumb-item type="active">{{ __($module_action) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card">
    <div class="card-body">

        {{-- Header --}}
        <div class="row align-items-center">
            <div class="col-8">
                <h4 class="card-title mb-0">
                    <i class="{{ $module_icon }}"></i>
                    {{ ${$module_name_singular}->name }}
                    <small class="text-muted fs-6 ms-1">{{ __($module_action) }}</small>
                </h4>
                <div class="small text-muted mt-1">
                    <span class="badge bg-secondary font-monospace">{{ ${$module_name_singular}->location }}</span>
                    &nbsp;Updated {{ ${$module_name_singular}->updated_at->diffForHumans() }}
                </div>
            </div>
            <div class="col-4">
                <div class="btn-toolbar float-end gap-1" role="toolbar">
                    <x-backend.buttons.return-back />
                    <x-backend.buttons.list
                        route="{{ route('backend.'.$module_name.'.index') }}"
                        title="{{ __('menu::text.menu_list') }}"
                        icon="fas fa-list"
                        small="true"
                    />
                    <a href="{{ route('backend.menuitems.create', ['menu_id' => ${$module_name_singular}->id]) }}"
                       class="btn btn-sm btn-success">
                        <i class="fas fa-plus-circle"></i> {{ __('menu::text.add_menu_item') }}
                    </a>
                    <x-backend.buttons.edit
                        route='{!!route("backend.$module_name.edit", ${$module_name_singular})!!}'
                        title="{{__('Edit')}} {{ $module_title }}"
                        small="true"
                    />
                </div>
            </div>
        </div>

        <hr>

        {{-- Meta Info --}}
        <div class="row">
            <div class="col-6 col-sm-3 mb-3">
                <label class="form-label small text-muted text-uppercase fw-semibold">Status</label>
                <div>
                    @if(${$module_name_singular}->is_active)
                        <span class="badge bg-success">Active</span>
                    @else
                        <span class="badge bg-warning text-dark">Inactive</span>
                    @endif
                    @if(${$module_name_singular}->is_visible)
                        <span class="badge bg-primary">Visible</span>
                    @else
                        <span class="badge bg-secondary">Hidden</span>
                    @endif
                    @if(${$module_name_singular}->is_public)
                        <span class="badge bg-info text-dark">Public</span>
                    @else
                        <span class="badge bg-dark">Private</span>
                    @endif
                </div>
            </div>
            <div class="col-6 col-sm-3 mb-3">
                <label class="form-label small text-muted text-uppercase fw-semibold">Locale</label>
                <p class="mb-0">{{ ${$module_name_singular}->locale ?? __('menu::text.all_locales') }}</p>
            </div>
            <div class="col-6 col-sm-3 mb-3">
                <label class="form-label small text-muted text-uppercase fw-semibold">Theme</label>
                <p class="mb-0">{{ ucfirst(${$module_name_singular}->theme ?? 'default') }}</p>
            </div>
            <div class="col-6 col-sm-3 mb-3">
                <label class="form-label small text-muted text-uppercase fw-semibold">Total Items</label>
                <p class="mb-0">
                    <span class="badge bg-primary rounded-pill fs-6">{{ ${$module_name_singular}->allItems->count() }}</span>
                </p>
            </div>
        </div>

        @if(${$module_name_singular}->description)
        <div class="alert alert-light border mb-3">
            <small class="text-muted">{{ ${$module_name_singular}->description }}</small>
        </div>
        @endif

        <hr>

        {{-- Menu Items Section --}}
        <div class="row mt-3">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0">
                        <i class="fas fa-layer-group"></i> Menu Items
                        <span class="badge bg-primary rounded-pill ms-1">{{ ${$module_name_singular}->allItems->count() }}</span>
                    </h5>
                    <div class="d-flex gap-2 align-items-center">
                        <button id="save-order-btn" class="btn btn-sm btn-outline-success d-none" onclick="saveOrder()">
                            <i class="fas fa-save"></i> Save Order
                        </button>
                        <a href="{{ route('backend.menuitems.create', ['menu_id' => ${$module_name_singular}->id]) }}"
                           class="btn btn-sm btn-success">
                            <i class="fas fa-plus-circle"></i> Add Item
                        </a>
                    </div>
                </div>

                @if(${$module_name_singular}->items->count() > 0)
                    <div class="alert alert-light border mb-2 py-2 px-3 small text-muted">
                        <i class="fas fa-info-circle"></i>
                        Drag rows to reorder. Indent items under a parent to create dropdowns. Click <strong>Save Order</strong> when done.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="menu-items-table">
                            <thead class="table-light">
                                <tr>
                                    <th style="width:30px"></th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>URL / Route</th>
                                    <th>Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-items">
                                @foreach(${$module_name_singular}->items->sortBy('sort_order') as $item)
                                    @include('menu::backend.menus.partials.menu-item-row', ['item' => $item, 'level' => 0])
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        {{ __('menu::text.no_menu_items') }}
                        <a href="{{ route('backend.menuitems.create', ['menu_id' => ${$module_name_singular}->id]) }}"
                           class="alert-link">
                            {{ __('menu::text.add_first_item') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="card-footer">
        <small class="text-muted">
            <strong>Created:</strong> {{ ${$module_name_singular}->created_at }} ({{ ${$module_name_singular}->created_at->diffForHumans() }})
            &nbsp;|&nbsp;
            <strong>Updated:</strong> {{ ${$module_name_singular}->updated_at }} ({{ ${$module_name_singular}->updated_at->diffForHumans() }})
        </small>
    </div>
</div>
@endsection

@push('after-scripts')
{{-- SortableJS for drag-and-drop reordering --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
const menuId = {{ ${$module_name_singular}->id }};
const sortUrl = "{{ route('backend.menus.sort_items', ${$module_name_singular}->id) }}";

const sortable = new Sortable(document.getElementById('sortable-items'), {
    animation: 150,
    handle: '.drag-handle',
    ghostClass: 'table-warning',
    onEnd: function () {
        document.getElementById('save-order-btn').classList.remove('d-none');
    }
});

function saveOrder() {
    const rows = document.querySelectorAll('#sortable-items tr[data-id]');
    const items = Array.from(rows).map((row, index) => ({
        id: parseInt(row.dataset.id),
        sort_order: index,
        parent_id: row.dataset.parentId ? parseInt(row.dataset.parentId) : null,
    }));

    fetch(sortUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ items }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('save-order-btn').classList.add('d-none');
            // Simple toast feedback
            const toast = document.createElement('div');
            toast.className = 'alert alert-success position-fixed top-0 end-0 m-3';
            toast.style.zIndex = 9999;
            toast.innerHTML = '<i class="fas fa-check-circle"></i> Order saved!';
            document.body.appendChild(toast);
            setTimeout(() => toast.remove(), 2500);
        }
    });
}
</script>
@endpush
