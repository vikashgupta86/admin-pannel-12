@extends('backend.layouts.app')

@section('title') {{ __($module_action) }} {{ __($module_title) }} @endsection

@section('breadcrumbs')
<x-backend.breadcrumbs>
    <x-backend.breadcrumb-item type="active" icon='{{ $module_icon }}'>{{ __($module_title) }}</x-backend.breadcrumb-item>
</x-backend.breadcrumbs>
@endsection

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body p-4">
        <x-backend.section-header :module_name="$module_name" :module_title="$module_title" :module_icon="$module_icon" :module_action="$module_action" />
        
        @if($menus->count() > 0)
            <div class="mt-4">
                @foreach($menus as $menu)
                    <div class="menu-accordion-item mb-3">
                        <div class="menu-accordion-header" data-bs-toggle="collapse" data-bs-target="#menu-{{ $menu->id }}" role="button">
                            <div class="d-flex align-items-center gap-2 flex-grow-1">
                                <div class="menu-toggle-icon">
                                    <i class="fa-solid fa-chevron-right"></i>
                                </div>
                                <div class="menu-icon-box">
                                    <i class="fa-solid fa-list-ul"></i>
                                </div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">{{ $menu->name }}</h6>
                                    <small class="text-muted ms-0">
                                        {{ $menu->items->count() }} @if($menu->items->count() == 1) {{ __('menumanage::text.item') }} @else {{ __('menumanage::text.items') }} @endif
                                    </small>
                                </div>
                            </div>
                            <span class="badge bg-primary rounded-pill">{{ $menu->location ?? 'Main' }}</span>
                        </div>
                        
                        @if($menu->items->count() > 0)
                            <div id="menu-{{ $menu->id }}" class="collapse show" data-bs-parent="">
                                <div class="menu-tree-container">
                                    <ul class="tree-list">
                                        @foreach($menu->items as $item)
                                            @include('menumanage::backend.menumanages.menu-item-tree', ['item' => $item, 'level' => 0])
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @else
                            <div class="menu-empty-state">
                                <p class="text-muted mb-0">
                                    <i class="fa-solid fa-inbox"></i>
                                    {{ __('menumanage::text.no_items') }}
                                </p>
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state-large">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-inbox"></i>
                </div>
                <p class="mt-3 text-muted">{{ __('menumanage::text.no_data') }}</p>
            </div>
        @endif
    </div>
</div>

@endsection

@push('after-styles')
<style>
    /* Accordion Styles */
    .menu-accordion-item {
        border: 1px solid #e9ecef;
        border-radius: 0.5rem;
        background: white;
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 1rem;
    }

    .menu-accordion-item:hover {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        border-color: #dee2e6;
    }

    .menu-accordion-header {
        padding: 1rem 1.25rem;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        cursor: pointer;
        user-select: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .menu-accordion-header:hover {
        background: linear-gradient(135deg, #5568d3 0%, #6a3d8f 100%);
    }

    .menu-accordion-header h6 {
        color: white;
        font-weight: 600;
        font-size: 1rem;
        margin: 0;
    }

    .menu-accordion-header .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
        font-size: 0.85rem;
    }

    .menu-toggle-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.5rem;
        height: 1.5rem;
        background: rgba(255, 255, 255, 0.2);
        border-radius: 0.375rem;
        transition: transform 0.3s ease;
        margin-right: 0.75rem;
    }

    .menu-accordion-header[aria-expanded="true"] .menu-toggle-icon {
        transform: rotate(90deg);
    }

    .menu-toggle-icon i {
        color: white;
        font-size: 0.75rem;
        display: block;
        transition: transform 0.3s ease;
    }

    .menu-icon-box {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 0.375rem;
        color: white;
        font-size: 1rem;
        margin-right: 1rem;
    }

    /* Tree Container */
    .menu-tree-container {
        padding: 1.25rem;
        background: #fafbfc;
    }

    .tree-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    /* Tree Items */
    .tree-item {
        list-style: none;
        margin-bottom: 0;
    }

    .tree-item-header {
        display: flex;
        align-items: center;
        padding: 0.75rem 0.75rem;
        border-radius: 0.375rem;
        transition: all 0.2s ease;
        cursor: pointer;
        user-select: none;
        margin-bottom: 0.25rem;
    }

    .tree-item-header:hover {
        background: white;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .tree-item-toggle {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        color: #667eea;
        transition: transform 0.3s ease;
        font-size: 0.7rem;
        flex-shrink: 0;
    }

    .tree-item.collapsed .tree-item-toggle {
        transform: rotate(-90deg);
    }

    .tree-item.no-children .tree-item-toggle {
        visibility: hidden;
    }

    .tree-item-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.75rem;
        height: 1.75rem;
        background: #f0f2f5;
        border-radius: 0.375rem;
        color: #667eea;
        margin-right: 0.5rem;
        font-size: 0.8rem;
        flex-shrink: 0;
    }

    .tree-item-info {
        flex: 1;
        min-width: 0;
        padding-right: 0.5rem;
    }

    .tree-item-name {
        display: block;
        font-weight: 500;
        color: #2d3748;
        font-size: 0.95rem;
        margin-bottom: 0.25rem;
        word-break: break-word;
    }

    .tree-item-url {
        display: block;
        font-size: 0.75rem;
        color: #a0aec0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .tree-item-badges {
        display: flex;
        gap: 0.4rem;
        flex-shrink: 0;
    }

    .tree-item-badge {
        display: inline-block;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.65rem;
        white-space: nowrap;
        font-weight: 500;
    }

    .badge-active {
        background-color: #d4edda;
        color: #155724;
    }

    .badge-inactive {
        background-color: #f8d7da;
        color: #721c24;
    }

    .badge-visible {
        background-color: #cfe2ff;
        color: #084298;
    }

    .badge-hidden {
        background-color: #e2e3e5;
        color: #383d41;
    }

    /* Nested Items */
    .tree-sub-list {
        list-style: none;
        padding: 0;
        margin: 0 0 0 0.625rem;
        padding-left: 0.75rem;
        border-left: 2px solid #e9ecef;
        display: none;
    }

    .tree-item.expanded .tree-sub-list {
        display: block;
    }

    .tree-sub-list .tree-item-header {
        padding-left: 0.5rem;
    }

    /* Level-specific styling */
    .tree-item-level-1 .tree-item-header {
        padding-left: 1.5rem;
    }

    .tree-item-level-2 .tree-item-header {
        padding-left: 0.75rem;
        background: rgba(102, 126, 234, 0.03);
    }

    .tree-item-level-3 .tree-item-header {
        padding-left: 0.75rem;
        opacity: 0.95;
    }

    /* Empty State */
    .menu-empty-state {
        padding: 1.5rem;
        text-align: center;
        color: #6c757d;
        background: white;
        border-top: 1px solid #e9ecef;
    }

    .empty-state-large {
        text-align: center;
        padding: 3rem 1rem;
    }

    .empty-state-icon {
        font-size: 3rem;
        color: #e9ecef;
        margin-bottom: 1rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .menu-accordion-header {
            padding: 0.875rem 1rem;
        }

        .menu-icon-box {
            width: 2rem;
            height: 2rem;
            font-size: 0.9rem;
        }

        .tree-item-badges {
            flex-wrap: wrap;
        }

        .tree-item-header {
            flex-wrap: wrap;
        }
    }
</style>
@endpush

@push('after-scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Initializing menu dropdowns...');
        
        // Handle accordion header clicks (menu headers)
        const accordionHeaders = document.querySelectorAll('.menu-accordion-header');
        accordionHeaders.forEach(header => {
            header.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const target = this.getAttribute('data-bs-target');
                if (target) {
                    const collapseElement = document.querySelector(target);
                    if (collapseElement) {
                        collapseElement.classList.toggle('show');
                        const toggleIcon = this.querySelector('.menu-toggle-icon i');
                        if (toggleIcon) {
                            if (collapseElement.classList.contains('show')) {
                                toggleIcon.style.transform = 'rotate(90deg)';
                            } else {
                                toggleIcon.style.transform = 'rotate(0deg)';
                            }
                        }
                    }
                }
            });
        });

        // Handle tree item toggles
        const treeHeaders = document.querySelectorAll('.tree-item-header');
        
        treeHeaders.forEach(header => {
            const parentItem = header.closest('.tree-item');
            if (parentItem && parentItem.classList.contains('has-children')) {
                header.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle expanded state
                    if (parentItem.classList.contains('expanded')) {
                        parentItem.classList.remove('expanded');
                        parentItem.classList.add('collapsed');
                    } else {
                        parentItem.classList.remove('collapsed');
                        parentItem.classList.add('expanded');
                    }
                });
            }
        });

        // Initialize tree items as collapsed
        document.querySelectorAll('.tree-item.has-children').forEach(item => {
            if (!item.classList.contains('expanded')) {
                item.classList.add('collapsed');
            }
        });

        // Initialize menu toggle icons
        document.querySelectorAll('.menu-accordion-header').forEach(header => {
            const collapseTarget = header.getAttribute('data-bs-target');
            if (collapseTarget) {
                const collapseElement = document.querySelector(collapseTarget);
                if (collapseElement && collapseElement.classList.contains('show')) {
                    const toggleIcon = header.querySelector('.menu-toggle-icon i');
                    if (toggleIcon) {
                        toggleIcon.style.transform = 'rotate(90deg)';
                    }
                }
            }
        });
    });
</script>
@endpush
