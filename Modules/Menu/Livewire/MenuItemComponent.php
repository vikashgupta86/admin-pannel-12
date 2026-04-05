<?php

namespace Modules\Menu\Livewire;

use Livewire\Component;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class MenuItemComponent extends Component
{
    // ---------------------------------------------------------------
    // Form properties — match menu_items columns exactly
    // ---------------------------------------------------------------
    public $menu_id;
    public $parent_id;
    public $type = '2';        // 1=File Link, 2=External Link, 3=Content Link
    public $name;
    public $slug;
    public $sort_order = 0;
    public $url;
    public $route_name;
    public $route_parameters;
    public $description;
    public $icon;
    public $badge_text;
    public $badge_color;
    public $opens_new_tab = 0;
    public $css_classes;
    public $html_attributes;
    public $permissions = [];
    public $roles = [];
    public $status = 1;
    public $is_active = 1;
    public $is_visible = 1;
    public $locale;
    public $meta_title;
    public $custom_data;
    public $note;
    public $link_place;
    public $link_position;
    public $content;   // for type=3 (rich text)

    // Dropdown data
    public $menus = [];
    public $parent_items = [];
    public $available_permissions = [];
    public $available_roles = [];

    // Item being edited (null = create mode)
    public $menuItem;

    // ---------------------------------------------------------------
    // Type constants (matches blade options)
    // ---------------------------------------------------------------
    const TYPE_FILE     = '1';
    const TYPE_EXTERNAL = '2';
    const TYPE_CONTENT  = '3';

    // ---------------------------------------------------------------
    // Lifecycle
    // ---------------------------------------------------------------
    public function mount($menuItem = null, $menu_id = null)
    {
        $this->menuItem = $menuItem;

        if ($menu_id && !$this->menuItem) {
            $this->menu_id = $menu_id;
        }

        $this->loadDropdownData();

        if ($this->menuItem) {
            $this->populateFormFromMenuItem();
        }
    }

    // ---------------------------------------------------------------
    // Watchers
    // ---------------------------------------------------------------
    public function updatedMenuId()
    {
        $this->parent_id = null;
        $this->loadParentItems();
    }

    public function updatedType()
    {
        // Clear URL/route when switching away from link types
        if (!in_array($this->type, [self::TYPE_EXTERNAL, self::TYPE_FILE])) {
            $this->url        = '';
            $this->route_name = '';
        }
    }

    public function updatedName()
    {
        if (empty($this->slug) && !empty($this->name)) {
            $this->generateSlug();
        }
    }

    // ---------------------------------------------------------------
    // Data loading
    // ---------------------------------------------------------------
    protected function loadDropdownData(): void
    {
        $this->menus = Menu::where('status', 1)
            ->where('is_active', true)
            ->pluck('name', 'id')
            ->toArray();

        $this->available_permissions = Permission::pluck('name', 'name')->toArray();
        $this->available_roles       = Role::pluck('name', 'name')->toArray();

        if ($this->menu_id) {
            $this->loadParentItems();
        }
    }

    protected function loadParentItems(): void
    {
        if (!$this->menu_id) {
            $this->parent_items = [];
            return;
        }

        $query = MenuItem::where('menu_id', $this->menu_id)
            ->where('is_active', true)
            ->where('is_visible', true)
            ->where('type', '!=', 'divider')
            ->orderBy('sort_order')
            ->orderBy('name');

        if ($this->menuItem) {
            $excludeIds = array_merge(
                [$this->menuItem->id],
                $this->getDescendantIds($this->menuItem->id)
            );
            $query->whereNotIn('id', $excludeIds);
        }

        $this->parent_items = $query->pluck('name', 'id')->toArray();

        // Reset parent_id if no longer valid
        if ($this->parent_id && !array_key_exists($this->parent_id, $this->parent_items)) {
            $this->parent_id = null;
        }
    }

    private function getDescendantIds(int $parentId, int $depth = 0, int $maxDepth = 10): array
    {
        if ($depth >= $maxDepth) {
            return [];
        }
        $descendants = [];
        foreach (MenuItem::where('parent_id', $parentId)->pluck('id') as $childId) {
            $descendants[] = $childId;
            $descendants   = array_merge($descendants, $this->getDescendantIds($childId, $depth + 1, $maxDepth));
        }
        return $descendants;
    }

    // ---------------------------------------------------------------
    // Populate form when editing
    // ---------------------------------------------------------------
    protected function populateFormFromMenuItem(): void
    {
        $item = $this->menuItem;

        $this->menu_id          = $item->menu_id;
        $this->loadParentItems();
        $this->parent_id        = $item->parent_id;
        $this->type             = (string) ($item->type ?? self::TYPE_EXTERNAL);
        $this->name             = $item->name;
        $this->slug             = $item->slug;
        $this->sort_order       = $item->sort_order ?? 0;
        $this->url              = $item->url;
        $this->route_name       = $item->route_name;
        $this->route_parameters = $item->route_parameters;
        $this->description      = $item->description;
        $this->icon             = $item->icon;
        $this->badge_text       = $item->badge_text;
        $this->badge_color      = $item->badge_color;
        $this->opens_new_tab    = $item->opens_new_tab ? 1 : 0;
        $this->css_classes      = $item->css_classes;
        $this->html_attributes  = is_array($item->html_attributes)
                                    ? json_encode($item->html_attributes)
                                    : $item->html_attributes;
        $this->permissions      = $item->permissions ?? [];
        $this->roles            = $item->roles ?? [];
        $this->status           = $item->status ?? 1;
        $this->is_active        = $item->is_active ? 1 : 0;
        $this->is_visible       = $item->is_visible ? 1 : 0;
        $this->locale           = $item->locale;
        $this->meta_title       = $item->meta_title;
        $this->custom_data      = is_array($item->custom_data)
                                    ? json_encode($item->custom_data)
                                    : $item->custom_data;
        $this->note             = $item->note;
        $this->link_place       = $item->link_place ?? null;
        $this->link_position    = $item->link_position ?? null;
        $this->content          = $item->content ?? null;
    }

    // ---------------------------------------------------------------
    // Validation rules
    // ---------------------------------------------------------------
    protected function rules(): array
    {
        $rules = [
            'menu_id'          => 'required|exists:menus,id',
            'name'             => 'required|string|max:255',
            'type'             => 'required|in:1,2,3',
            'status'           => 'required|in:0,1,2',
            'sort_order'       => 'nullable|integer|min:0',
            'url'              => 'nullable|string|max:500',
            'route_name'       => 'nullable|string|max:255',
            'route_parameters' => 'nullable|json',
            'html_attributes'  => 'nullable|json',
            'custom_data'      => 'nullable|json',
            'slug'             => 'nullable|string|max:255',
            'description'      => 'nullable|string|max:1000',
            'icon'             => 'nullable|string|max:100',
            'badge_text'       => 'nullable|string|max:50',
            'badge_color'      => 'nullable|string|max:20',
            'css_classes'      => 'nullable|string|max:500',
            'locale'           => 'nullable|string|max:5',
            'meta_title'       => 'nullable|string|max:255',
            'note'             => 'nullable|string|max:1000',
        ];

        if ($this->slug) {
            $uniqueRule = 'unique:menu_items,slug';
            if ($this->menuItem) {
                $uniqueRule .= ',' . $this->menuItem->id;
            }
            $rules['slug'] = 'nullable|string|max:255|' . $uniqueRule;
        }

        return $rules;
    }

    // ---------------------------------------------------------------
    // Save
    // ---------------------------------------------------------------
    public function save()
    {
        $this->validate();

        try {
            $this->validateJsonFields();

            if (empty($this->slug) && !empty($this->name)) {
                $this->generateSlug();
            }

            $data = $this->prepareDataForSave();

            if ($this->menuItem) {
                $this->menuItem->update($data);
                $message  = 'Menu Item "' . $this->name . '" updated successfully!';
                $redirect = route('backend.menuitems.show', $this->menuItem->id);
                logUserAccess('MenuItem Update | Id: ' . $this->menuItem->id);
            } else {
                $item     = MenuItem::create($data);
                $message  = 'Menu Item "' . $this->name . '" created successfully!';
                $redirect = route('backend.menuitems.show', $item->id);
                logUserAccess('MenuItem Store | Id: ' . $item->id);
            }

            // Clear cache
            $menu = Menu::find($this->menu_id);
            if ($menu) {
                Menu::clearMenuCache($menu->location);
            }

            session()->flash('flash_success', $message);
            return redirect($redirect);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            $this->addError('general', 'Error saving menu item: ' . $e->getMessage());
        }
    }

    // ---------------------------------------------------------------
    // Helpers
    // ---------------------------------------------------------------
    protected function validateJsonFields(): void
    {
        foreach (['route_parameters', 'html_attributes', 'custom_data'] as $field) {
            if (!empty($this->$field) && trim($this->$field) !== '') {
                json_decode($this->$field, true);
                if (json_last_error() !== JSON_ERROR_NONE) {
                    $this->addError($field, ucwords(str_replace('_', ' ', $field)) . ' must be valid JSON.');
                }
            }
        }
    }

    protected function prepareDataForSave(): array
    {
        return [
            'menu_id'          => $this->menu_id,
            'parent_id'        => $this->parent_id ?: null,
            'type'             => $this->type,
            'name'             => $this->name,
            'slug'             => $this->slug ?: null,
            'sort_order'       => (int) ($this->sort_order ?? 0),
            'url'              => $this->url ?: null,
            'route_name'       => $this->route_name ?: null,
            'route_parameters' => $this->route_parameters ?: null,
            'description'      => $this->description ?: null,
            'icon'             => $this->icon ?: null,
            'badge_text'       => $this->badge_text ?: null,
            'badge_color'      => $this->badge_color ?: null,
            'opens_new_tab'    => (bool) $this->opens_new_tab,
            'css_classes'      => $this->css_classes ?: null,
            'html_attributes'  => $this->html_attributes ?: null,
            'permissions'      => $this->permissions ?: null,
            'roles'            => $this->roles ?: null,
            'status'           => (int) $this->status,
            'is_active'        => (bool) $this->is_active,
            'is_visible'       => (bool) $this->is_visible,
            'locale'           => $this->locale ?: null,
            'meta_title'       => $this->meta_title ?: null,
            'custom_data'      => $this->custom_data ?: null,
            'note'             => $this->note ?: null,
            'link_place'       => $this->link_place ?: null,
            'link_position'    => $this->link_position ?: null,
            'content'          => $this->content ?: null,
        ];
    }

    public function generateSlug(): void
    {
        if ($this->name) {
            $this->slug = \Illuminate\Support\Str::slug($this->name);
        }
    }

    public function resetForm(): void
    {
        $this->reset([
            'menu_id', 'parent_id', 'name', 'slug', 'sort_order', 'url',
            'route_name', 'route_parameters', 'description', 'icon',
            'badge_text', 'badge_color', 'css_classes', 'html_attributes',
            'permissions', 'roles', 'locale', 'meta_title', 'custom_data', 'note',
            'link_place', 'link_position', 'content',
        ]);

        $this->type          = self::TYPE_EXTERNAL;
        $this->status        = 1;
        $this->is_active     = 1;
        $this->is_visible    = 1;
        $this->opens_new_tab = 0;
        $this->sort_order    = 0;

        $this->resetErrorBag();
        $this->loadDropdownData();
    }

    public function render()
    {
        return view('menu::livewire.menu-item-component');
    }
}
