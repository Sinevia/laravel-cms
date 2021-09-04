<?php

namespace Sinevia\Cms\Http\Controllers;

trait MenuTrait {

    /**
     * Shows the menuitems  manager page
     * @return string
     */
    public function getMenuitemManager() {
        $menu = \Sinevia\Cms\Models\Menu::withTrashed()->find(request('menu_id'));
        if ($menu == null) {
            return back()->withErrors('Menu not found');
        }

        $pages = \Sinevia\Cms\Models\Page::orderBy('Alias', 'ASC')
                ->get();

        return view('cms::admin.menuitem-manager', get_defined_vars());
    }

    /**
     * Shows the menus manager page
     * @return string
     */
    public function getMenuManager() {
        $view = request('view', '');
        $filterStatus = request('filter_status', '');
        $filterSearch = request('filter_search', '');
        if ($view == 'trash') {
            $filterStatus = 'deleted';
        }
        if ($filterStatus == 'deleted') {
            $view = 'trash';
        }
        $session_order_by = \Session::get('websites_menu_manager_by', 'title');
        $session_order_sort = \Session::get('websites_menu_manager_sort', 'asc');

        $orderby = request('by', $session_order_by);
        $sort = request('sort', $session_order_sort);
        $menu = request('page', 0);
        $results_per_page = 20;

        if (in_array(strtolower($sort), ["asc", "desc"]) == false) {
            $sort = 'ASC';
        }

        \Session::put('cms_menu_manager_by', $orderby); // Keep for session
        \Session::put('cms_menu_manager_sort', $sort);  // Keep for session

        $query = \Sinevia\Cms\Models\Menu::orderBy($orderby, $sort);

        if ($filterStatus == "") {
            $query = $query->where('status', '<>', 'deleted');
        }
        if ($filterStatus != "") {
            $query = $query->where('status', '=', $filterStatus);
        }
        if ($filterSearch != "") {
            $query = $query->where('name', 'LIKE', '%' . $filterSearch . '%');
        }
        if ($view == 'trash') {
            $query = $query->withTrashed();
        }


        $menus = $query->paginate($results_per_page);

        return view('cms::admin/menu-manager', get_defined_vars());
    }

    /**
     * Shows the website update form
     * @return string
     */
    public function getMenuUpdate() {
        $menu = \Sinevia\Cms\Models\Menu::withTrashed()->find(request('menu_id'));
        if ($menu == null) {
            return back()->withErrors('Menu not found');
        }

        $title = request('title', old('title', $menu->Title));
        $status = request('status', old('status', $menu->Status));

        return view('cms::admin.menu-update', get_defined_vars());
    }

    /**
     * Creates a new website
     * @return string
     */
    public function postMenuCreate() {
        $rules = array(
            'title' => 'required', // required
        );
        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput(\Request::all());
        }
        $title = request('title', '');

        \DB::beginTransaction();
        try {
            $menu = new \Sinevia\Cms\Models\Menu;
            $menu->Title = $title;
            $menu->Status = \Sinevia\Cms\Models\Menu::STATUS_DRAFT;
            $result = $menu->save();
            if ($result == false) {
                return back()->withErrors('Menu failed to be saved.')->withInput(\Request::all());
            }
            \DB::commit();
            return back()->withSuccess('Menu successfully saved.');
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Menu failed to be created";
            return back()->withErrors($error)->withInput(\Request::all());
        }
    }

    /**
     * Fully deletes a website with all pages, blocks, etc
     * Use with caution
     * @return string
     */
    public function postMenuDelete() {
        $menu = \Sinevia\Cms\Models\Menu::withTrashed()->find(request('menu_id'));
        if ($menu == null) {
            return back()->withErrors('Menu not found');
        }

        \DB::beginTransaction();
        try {
            $result = $menu->forceDelete();

            if ($result == false) {
                return \Redirect::back()->withErrors('Menu failed to be deleted')->withInput(\Request::all());
            }
            \DB::commit();
            return back()->withSuccess('Menu successfully deleted');
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Menu failed to be deleted";
            return back()->withErrors($error)->withInput(\Request::all());
        }
    }

    /**
     * Moves a page to the trash bin
     * @return string
     */
    public function postMenuMoveToTrash() {
        $menu = \Sinevia\Cms\Models\Menu::withTrashed()->find(request('menu_id'));
        if ($menu == null) {
            return back()->withErrors('Menu not found');
        }

        \DB::beginTransaction();
        try {
            $menu->status = \Sinevia\Cms\Models\Menu::STATUS_DELETED;
            $menu->save();
            $result = $menu->delete();

            if ($result == false) {
                return \Redirect::back()->withErrors('Menu failed to be moved to Trash')->withInput(\Request::all());
            }
            \DB::commit();
            return back()->withSuccess('Menu successfully moved to Trash');
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Menu failed to be moved to Trash";
            return back()->withErrors($error)->withInput(\Request::all());
        }
    }

    /**
     * Updates a page
     * @return string
     */
    public function postMenuUpdate() {
        $menu = \Sinevia\Cms\Models\Menu::withTrashed()->find(request('menu_id'));
        if ($menu == null) {
            return back()->withErrors('Menu not found');
        }

        $rules = array(
            'title' => 'required', // required
            'status' => 'required', // required
        );
        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Request::all());
        }

        $title = request('title');
        $status = request('status');

        \DB::beginTransaction();
        try {
            $menu->status = $status;
            $menu->title = $title;

            $result = $menu->save();
            if ($result == false) {
                return \Redirect::back()->withErrors('Menu failed to be saved.')->withInput(\Request::all());
            }
            \DB::commit();
            return back()->withSuccess('Menu successfully saved.');
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Menu failed to be saved";
            return back()->withErrors($error)->withInput(\Request::all());
        }
    }

    function nodeMap($menuitem) {
        $children = $menuitem->children->map(function($item){
            return $this->nodeMap($item);
        });
        return [
            'id' => $menuitem->Id,
            'name' => $menuitem->Title,
            'parent_id' => $menuitem->ParentId,
            'target' => $menuitem->Target,
            'url' => $menuitem->Url,
            'page_id' => $menuitem->PageId,
            'children' => $children,
        ];
    }

    public function anyMenuitemsFetchAjax() {
        $menu = \Sinevia\Cms\Models\Menu::withTrashed()->find(request('menu_id'));
        if ($menu == null) {
            return response()->json(['status' => 'error', 'message' => 'Menu not found']);
        }

        $treeMenuItems = $menu->treeMenuItems()->map(function($menuitem) {
            return $this->nodeMap($menuitem);
            return [
                'id' => $entry->Id,
                'name' => $entry->Title,
                'parent_id' => $entry->ParentId,
                'target' => $entry->Target,
                'url' => $entry->Url,
                'page_id' => $entry->PageId,
            ];
        });

        $treeMenuItems = json_encode($treeMenuItems);

        $menuitems = json_decode($treeMenuItems, true);

        // dd($treeMenuItems);

        return response()->json(['status' => 'success', 'data' => ['menuitems' => $menuitems]]);
    }

    public function anyMenuitemsSaveAjax() {
        $menu = \Sinevia\Cms\Models\Menu::withTrashed()->find(request('menu_id'));
        if ($menu == null) {
            return response()->json(['status' => 'error', 'message' => 'Menu not found']);
        }

        $rules = array(
            'data' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => '"data" is required field']);
        }

        $data = json_decode(request('data'), true);

        if (is_array($data) == false) {
            return response()->json(['status' => 'error', 'message' => 'Data must be an array']);
        }

        $flattenedMenuItems = $this->flatten($data);

        $oldNewMap = [];
        $idsToKeep = []; // IDs of the menu items, which wil be kept, the rest will be deleted

        \DB::beginTransaction();
        try {
            // 1. Upsert menu items
            foreach ($flattenedMenuItems as $fmi) {
                $oldId = $fmi['id'];
                $oldParentId = $fmi['parent_id'];
                $newParentId = isset($oldNewMap[$oldParentId]) ? $oldNewMap[$oldParentId] : null;
                $menuItem = is_numeric($oldId) ? \Sinevia\Cms\Models\MenuItem::find($oldId) : null; // Ohhhh SQL Server :)
                if ($menuItem == null) {
                    $menuItem = new \Sinevia\Cms\Models\MenuItem;
                    $menuItem->MenuId = $menu->Id;
                }
                $menuItem->Title = $fmi['name'];
                $menuItem->ParentId = $newParentId;
                $menuItem->PageId = $fmi['page_id'] ?? '0';
                $menuItem->Url = $fmi['url'] ?? '';
                $menuItem->Target = $fmi['target'] ?? '_self';
                $menuItem->Sequence = $fmi['sequence'] ?? '999';
                $isSaved = $menuItem->save();
                $oldNewMap[$oldId] = $menuItem->Id; // map old ID with new ID
                $idsToKeep[] = $menuItem->Id;
            }

            // 2. Delete old menu items
            $menu->menuitems->whereNotIn('Id', $idsToKeep)->each(function($item, $key) {
                $item->delete();
            });

            \DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Saved']);
        } catch (Exception $e) {
            \DB::rollback();
            return response()->json(['status' => 'error', 'message' => 'Menu items failed to be saved']);
        }
    }

    function flatten($input, $parentId = null) {
        $output = [];

        // For each object in the array
        foreach ($input as $index => $row) {

            // separate its children
            $children = isset($row['children']) ? $row['children'] : [];

            if (isset($row['children'])) {
                unset($row['children']);
            }

            $row['parent_id'] = $parentId;
            $row['sequence'] = ($index + 1);

            // and add it to the output array
            $output[] = $row;

            // Recursively flatten the array of children
            $children = $this->flatten($children, $row['id']);

            //  and add the result to the output array
            foreach ($children as $index => $child) {
                $child['sequence'] = ($index + 1);
                $output[] = $child;
            }
        }
        return $output;
    }

}
