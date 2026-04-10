<?php

namespace Modules\MenuManage\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;
use Modules\Menu\Models\Menu;
use Modules\MenuManage\Http\Requests\MenuRequest;
use Modules\MenuManage\Http\Requests\MenuUpdateRequest;
use Modules\MenuManage\Http\Requests\MenuManageRequest;
use Illuminate\Http\Request;
 
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class MenuManagesController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'MenuManages';

        // module name
        $this->module_name = 'menumanages';

        // directory path of the module
        $this->module_path = 'menumanage::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\MenuManage\Models\MenuManage";
    }



    public function index()
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';
        $menus = Menu::with('items.children.children.children')->get();

        logUserAccess($module_title.' '.$module_action);

        return view(
            "{$module_path}.{$module_name}.index_datatable",
            compact('module_title', 'module_name', 'menus', 'module_icon', 'module_name_singular', 'module_action')
        );
    }

    /**
     * Retrieves a list of items based on the search term.
     *
     * @param  Request  $request  The HTTP request object.
     * @return JsonResponse The JSON response containing the list of items.
     */
    public function index_list(Request $request)
    {
        $module_title = $this->module_title;
        $module_name = $this->module_name;
        $module_path = $this->module_path;
        $module_icon = $this->module_icon;
        $module_model = $this->module_model;
        $module_name_singular = Str::singular($module_name);

        $module_action = 'List';

        $term = trim($request->q);

        if (empty($term)) {
            return response()->json([]);
        }

        $query_data = $module_model::where('name', 'LIKE', "%{$term}%")->orWhere('slug', 'LIKE', "%{$term}%")->active()->limit(7)->get();

        $$module_name = [];

        foreach ($query_data as $row) {
            $$module_name[] = [
                'id' => $row->id,
                'text' => $row->name,
            ];
        }

        logUserAccess($module_title.' '.$module_action);

        return response()->json($$module_name);
    }}