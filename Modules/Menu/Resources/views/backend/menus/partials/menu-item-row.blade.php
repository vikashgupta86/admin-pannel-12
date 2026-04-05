<tr data-id="{{ $item->id }}" data-parent-id="{{ $item->parent_id ?? '' }}">
    <td class="text-center" style="width:30px; cursor:grab">
        <i class="fas fa-grip-vertical text-muted drag-handle"></i>
    </td>
    <td>
        @for($i = 0; $i < $level; $i++)
            <span class="ms-3"></span>
        @endfor
        @if($level > 0)
            <i class="fas fa-angle-right text-muted me-1"></i>
        @endif
        @if($item->icon)
            <i class="{{ $item->icon }} me-1"></i>
        @endif
        <strong>{{ $item->name }}</strong>
        @if($item->badge_text)
            <span class="badge bg-{{ $item->badge_color ?? 'secondary' }} ms-1">{{ $item->badge_text }}</span>
        @endif
    </td>
    <td>
        <span class="badge bg-light text-dark border">{{ $item->type }}</span>
    </td>
    <td class="text-muted small font-monospace">
        {{ Str::limit($item->url ?? $item->route_name ?? '—', 40) }}
        @if($item->opens_new_tab)
            <i class="fas fa-external-link-alt text-muted ms-1" title="Opens in new tab"></i>
        @endif
    </td>
    <td>
        @if($item->is_active && $item->is_visible)
            <span class="badge bg-success">Active</span>
        @elseif(!$item->is_active)
            <span class="badge bg-warning text-dark">Inactive</span>
        @else
            <span class="badge bg-secondary">Hidden</span>
        @endif
    </td>
    <td class="text-center">
        <div class="btn-group btn-group-sm">
            <a href="{{ route('backend.menuitems.edit', $item->id) }}"
               class="btn btn-outline-primary" title="Edit">
                <i class="fas fa-pencil-alt"></i>
            </a>
            <a href="{{ route('backend.menuitems.show', $item->id) }}"
               class="btn btn-outline-secondary" title="View">
                <i class="fas fa-eye"></i>
            </a>
            <form action="{{ route('backend.menuitems.destroy', $item->id) }}"
                  method="POST" class="d-inline"
                  onsubmit="return confirm('Delete \'{{ $item->name }}\'?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" title="Delete">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@if($item->children && $item->children->count() > 0)
    @foreach($item->children->sortBy('sort_order') as $child)
        @include('menu::backend.menus.partials.menu-item-row', ['item' => $child, 'level' => $level + 1])
    @endforeach
@endif
