<?php

namespace Modules\Menu\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Modules\Menu\Models\Menu;
use Modules\Menu\Models\MenuItem;

class MenusController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        $this->module_title = 'Menus';
        $this->module_name = 'menus';
        $this->module_path = 'menu::backend';
        $this->module_icon = 'fa-solid fa-list';
        $this->module_model = "Modules\\Menu\\Models\\Menu";
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Show';

        $$module_name_singular = $module_model::with([
            'items.children.children.children.children',
        ])->findOrFail($id);

        logUserAccess($module_title . ' ' . $module_action . ' | Id: ' . $$module_name_singular->id);

        return view(
            "{$module_path}.{$module_name}.show",
            compact('module_title', 'module_name', 'module_path', 'module_icon', 'module_name_singular', 'module_action', "{$module_name_singular}")
        );
    }

    /**
     * Updates a resource.
     */
    public function update(Request $request, $id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);
        $module_action = 'Update';

        $$module_name_singular = $module_model::findOrFail($id);
        $$module_name_singular->update($request->all());

        Menu::clearMenuCache($$module_name_singular->location);

        flash(Str::singular($module_title) . "' Updated Successfully")->success()->important();
        logUserAccess($module_title . ' ' . $module_action . ' | Id: ' . $$module_name_singular->id);

        return redirect()->route("backend.{$module_name}.show", $$module_name_singular->id);
    }

    /**
     * Remove the specified resource from storage.
     * Prevents deletion if the menu has menu items.
     */
    public function destroy($id)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_name_singular = Str::singular($module_name);
        $module_model = $this->module_model;
        $module_action = 'Destroy';

        $$module_name_singular = $module_model::findOrFail($id);

        if ($$module_name_singular->allItems()->count() > 0) {
            $itemCount = $$module_name_singular->allItems()->count();
            flash("Cannot delete menu '" . $$module_name_singular->name . "'! This menu has {$itemCount} menu item(s). Please delete all menu items first.", 'warning');
            logUserAccess($module_title . ' ' . $module_action . ' Failed | Id: ' . $$module_name_singular->id . ' | Reason: Has menu items');
            return redirect()->route("backend.{$module_name}.index");
        }

        $location = $$module_name_singular->location;
        $$module_name_singular->delete();
        Menu::clearMenuCache($location);

        flash(Str::singular($module_title) . ' Deleted Successfully!')->success()->important();
        logUserAccess($module_title . ' ' . $module_action . ' | Id: ' . $$module_name_singular->id);

        return redirect()->route("backend.{$module_name}.index");
    }

    /**
     * Update sort order of menu items via AJAX (drag-and-drop builder).
     * POST /admin/menus/{id}/sort-items
     */
    public function sortItems(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        $request->validate([
            'items'              => 'required|array',
            'items.*.id'         => 'required|integer|exists:menu_items,id',
            'items.*.sort_order' => 'required|integer|min:0',
            'items.*.parent_id'  => 'nullable|integer|exists:menu_items,id',
        ]);

        foreach ($request->items as $itemData) {
            MenuItem::where('id', $itemData['id'])
                ->where('menu_id', $menu->id)
                ->update([
                    'sort_order' => $itemData['sort_order'],
                    'parent_id'  => $itemData['parent_id'] ?? null,
                ]);
        }

        Menu::clearMenuCache($menu->location);

        return response()->json(['success' => true, 'message' => 'Menu order saved.']);
    }

    /**
     * Toggle active/visible/public status quickly via AJAX.
     * PATCH /admin/menus/{id}/toggle
     */
    public function toggle(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);
        $field = $request->input('field', 'is_active');

        if (!in_array($field, ['is_active', 'is_visible', 'is_public'])) {
            return response()->json(['error' => 'Invalid field.'], 422);
        }

        $menu->update([$field => !$menu->$field]);
        Menu::clearMenuCache($menu->location);

        return response()->json(['success' => true, 'value' => (bool) $menu->$field]);
    }
}
