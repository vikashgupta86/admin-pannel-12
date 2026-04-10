<li class="tree-item {{ $item->children->count() > 0 ? 'has-children collapsed' : 'no-children' }} tree-item-level-{{ $level }}">
    <div class="tree-item-header">
        @if($item->children->count() > 0)
            <span class="tree-item-toggle">
                <i class="fa-solid fa-chevron-down"></i>
            </span>
        @endif
        
        <div class="tree-item-icon">
            <i class="fa-solid fa-link"></i>
        </div>
        
        <div class="tree-item-info">
            <span class="tree-item-name">{{ $item->name }}</span>
            @if($item->url)
                <span class="tree-item-url" title="{{ $item->url }}">{{ $item->url }}</span>
            @elseif($item->route_name)
                <span class="tree-item-url" title="Route: {{ $item->route_name }}">{{ $item->route_name }}</span>
            @endif
        </div>
        
        <div class="tree-item-badges">
            @if($item->is_active)
                <span class="tree-item-badge badge-active">
                    <i class="fa-solid fa-check-circle"></i> Active
                </span>
            @else
                <span class="tree-item-badge badge-inactive">
                    <i class="fa-solid fa-ban"></i> Inactive
                </span>
            @endif
            
            @if($item->is_visible)
                <span class="tree-item-badge badge-visible">
                    <i class="fa-solid fa-eye"></i> Visible
                </span>
            @else
                <span class="tree-item-badge badge-hidden">
                    <i class="fa-solid fa-eye-slash"></i> Hidden
                </span>
            @endif
        </div>
    </div>
    
    @if($item->children->count() > 0)
        <ul class="tree-sub-list">
            @foreach($item->children as $child)
                @include('menumanage::backend.menumanages.menu-item-tree', ['item' => $child, 'level' => $level + 1])
            @endforeach
        </ul>
    @endif
</li>
