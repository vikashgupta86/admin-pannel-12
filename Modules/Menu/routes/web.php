<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Backend Routes
|--------------------------------------------------------------------------
*/
Route::group([
    'namespace'  => '\Modules\Menu\Http\Controllers\Backend',
    'as'         => 'backend.',
    'middleware' => ['web', 'auth', 'can:view_backend'],
    'prefix'     => 'admin',
], function () {

    /*
     * Menu Routes
     */
    $module_name       = 'menus';
    $controller_name   = 'MenusController';

    Route::get("$module_name/index_list", ['as' => "$module_name.index_list", 'uses' => "$controller_name@index_list"]);
    Route::get("$module_name/index_data", ['as' => "$module_name.index_data", 'uses' => "$controller_name@index_data"]);
    Route::get("$module_name/trashed",    ['as' => "$module_name.trashed",    'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);

    // Drag-and-drop sort order save
    Route::post("$module_name/{id}/sort-items", ['as' => "$module_name.sort_items", 'uses' => "$controller_name@sortItems"]);

    // Quick toggle (is_active / is_visible / is_public)
    Route::patch("$module_name/{id}/toggle", ['as' => "$module_name.toggle", 'uses' => "$controller_name@toggle"]);

    Route::resource("$module_name", "$controller_name");

    /*
     * Menu Item Routes
     */
    $module_name     = 'menuitems';
    $controller_name = 'MenuItemsController';

    Route::get("$module_name", function () {
        flash('Menu items are listed within their parent menus.')->info();
        return redirect()->route('backend.menus.index');
    })->name("$module_name.index");

    Route::get("$module_name/trashed",        ['as' => "$module_name.trashed", 'uses' => "$controller_name@trashed"]);
    Route::patch("$module_name/trashed/{id}", ['as' => "$module_name.restore", 'uses' => "$controller_name@restore"]);

    // Quick toggle for menu items
    Route::patch("$module_name/{id}/toggle", ['as' => "$module_name.toggle", 'uses' => "$controller_name@toggle"]);

    Route::resource("$module_name", "$controller_name")->except(['index']);
});
