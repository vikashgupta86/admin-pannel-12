<?php

namespace Modules\Menu\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Menu extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'menus';

    protected function casts(): array
    {
        return [
            'settings'    => 'array',
            'permissions' => 'array',
            'roles'       => 'array',
            'is_public'   => 'boolean',
            'is_active'   => 'boolean',
            'is_visible'  => 'boolean',
        ];
    }

    // ---------------------------------------------------------------
    // Relationships
    // ---------------------------------------------------------------

    /** Root-level items only. */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class)->whereNull('parent_id')->orderBy('sort_order');
    }

    /** All items (including nested). */
    public function allItems(): HasMany
    {
        return $this->hasMany(MenuItem::class)->orderBy('sort_order');
    }

    // ---------------------------------------------------------------
    // Scopes
    // ---------------------------------------------------------------

    public function scopeByLocation($query, string $location)
    {
        return $query->where('location', $location);
    }

    public function scopeActiveAndVisible($query)
    {
        return $query->where('is_active', true)->where('is_visible', true);
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    public function scopeByLocale($query, string $locale)
    {
        return $query->where('locale', $locale);
    }

    public function scopeAccessibleByUser($query, $user = null)
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();

        if (!$user) {
            return $query->where('is_public', true);
        }

        $userPermissions = $user->getPermissionNames()->toArray();
        $userRoles       = $user->getRoleNames()->toArray();

        return $query->where(function ($q) use ($userPermissions, $userRoles) {
            $q->where('is_public', true)
                ->orWhere(function ($access) use ($userPermissions, $userRoles) {
                    $access->where(function ($perm) use ($userPermissions) {
                        $perm->whereNull('permissions');
                        foreach ($userPermissions as $p) {
                            $perm->orWhereJsonContains('permissions', $p);
                        }
                    })->orWhere(function ($role) use ($userRoles) {
                        $role->whereNull('roles');
                        foreach ($userRoles as $r) {
                            $role->orWhereJsonContains('roles', $r);
                        }
                    });
                });
        });
    }

    // ---------------------------------------------------------------
    // Cache
    // ---------------------------------------------------------------

    /**
     * Get the cache version key for a location (invalidation via version bump).
     */
    public static function getMenuCacheVersion(string $location): string
    {
        return (string) Cache::rememberForever("menu_version_{$location}", fn () => time());
    }

    /**
     * Get cached, hierarchical menu data for a location.
     *
     * @param  string       $location  Menu location identifier
     * @param  mixed|null   $user      Authenticated user (null = guest)
     * @param  string|null  $locale    Locale override (defaults to app locale)
     */
    public static function getCachedMenuData(
        string $location,
        $user = null,
        ?string $locale = null
    ): \Illuminate\Support\Collection {
        $locale        = $locale ?? app()->getLocale();
        $defaultLocale = config('app.fallback_locale', 'en');
        $version       = static::getMenuCacheVersion($location);
        $userId        = $user ? $user->id : 'guest';
        $cacheKey      = "menu_data_{$location}_{$userId}_{$locale}_{$version}";

        return Cache::remember($cacheKey, 3600, function () use ($location, $user, $locale, $defaultLocale) {
            return static::buildMenuData($location, $user, $locale, $defaultLocale);
        });
    }

    /**
     * Build hierarchical menu data (called inside the cache closure).
     */
    protected static function buildMenuData(
        string $location,
        $user,
        string $locale,
        string $defaultLocale
    ): \Illuminate\Support\Collection {
        $menus = static::getMenusForLocale($location, $user, $locale);

        // Fall back to default locale if nothing found
        if ($menus->isEmpty() && $locale !== $defaultLocale) {
            $menus  = static::getMenusForLocale($location, $user, $defaultLocale);
            $locale = $defaultLocale;
        }

        if ($menus->isEmpty()) {
            return collect();
        }

        // Load all items for these menus in one query
        $menuIds      = $menus->pluck('id');
        $allItems     = MenuItem::whereIn('menu_id', $menuIds)
            ->where('is_visible', true)
            ->where('is_active', true)
            ->where(function ($q) use ($locale) {
                $q->where('locale', $locale)->orWhereNull('locale');
            })
            ->orderBy('menu_id')
            ->orderBy('parent_id')
            ->orderBy('sort_order')
            ->get();

        // Filter by user permissions
        $accessibleItems = $allItems->filter(fn ($item) => $item->userCanSee($user));

        $itemsByMenu = $accessibleItems->groupBy('menu_id');

        return $menus->map(function ($menu) use ($itemsByMenu) {
            $menuItems             = $itemsByMenu->get($menu->id, collect());
            $menu->hierarchicalItems = static::buildHierarchy($menuItems);
            return $menu;
        })->filter(fn ($m) => $m->hierarchicalItems->isNotEmpty());
    }

    protected static function getMenusForLocale(string $location, $user, string $locale): \Illuminate\Support\Collection
    {
        return static::byLocation($location)
            ->activeAndVisible()
            ->where(fn ($q) => $q->where('locale', $locale)->orWhereNull('locale'))
            ->get()
            ->filter(fn ($m) => $m->userCanSee($user));
    }

    protected static function buildHierarchy(\Illuminate\Support\Collection $items): \Illuminate\Support\Collection
    {
        if ($items->isEmpty()) {
            return collect();
        }

        $itemsById = $items->keyBy('id');
        $roots     = collect();

        foreach ($items as $item) {
            $item->children = collect();
        }

        foreach ($items as $item) {
            if ($item->parent_id === null) {
                $roots->push($item);
            } elseif ($parent = $itemsById->get($item->parent_id)) {
                $parent->children->push($item);
            }
        }

        return static::sortRecursively($roots);
    }

    protected static function sortRecursively(\Illuminate\Support\Collection $items): \Illuminate\Support\Collection
    {
        $sorted = $items->sortBy('sort_order');
        foreach ($sorted as $item) {
            if (isset($item->children) && $item->children->isNotEmpty()) {
                $item->children = static::sortRecursively($item->children);
            }
        }
        return $sorted;
    }

    // ---------------------------------------------------------------
    // Cache invalidation
    // ---------------------------------------------------------------

    /**
     * Clear cached menus for a specific location by bumping the version.
     */
    public static function clearMenuCache(?string $location = null): void
    {
        if ($location) {
            Cache::forever("menu_version_{$location}", (string) time());
        } else {
            static::clearAllMenuCaches();
        }
    }

    /**
     * Flush all menu version keys (global clear).
     * Note: requires tagged cache or a flush on non-tagged drivers.
     */
    public static function clearAllMenuCaches(): void
    {
        Cache::flush();
    }

    // ---------------------------------------------------------------
    // Permission check
    // ---------------------------------------------------------------

    public function userCanSee($user = null): bool
    {
        $user = $user ?? \Illuminate\Support\Facades\Auth::user();

        if ($this->is_public) {
            return true;
        }

        if (!$user) {
            return false;
        }

        if ($this->permissions && is_array($this->permissions) && !empty($this->permissions)) {
            foreach ($this->permissions as $permission) {
                if ($user->can($permission)) {
                    return true;
                }
            }
            return false;
        }

        return true;
    }

    // ---------------------------------------------------------------
    // Factory
    // ---------------------------------------------------------------

    protected static function newFactory()
    {
        return \Modules\Menu\database\factories\MenuFactory::new();
    }
}
