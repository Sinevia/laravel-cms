<?php

namespace Sinevia\Cms\Http\Controllers;

/**
 * Contains simple CMS functionality
 */
class CmsController extends \Illuminate\Routing\Controller {

    use MenuTrait;

    function anyIndex() {
        return $this->getPageManager();
    }

    function anyPageView($slug = "") {
        //$alias = '/' . ltrim($slug, '/');

        $uri = \Request::path();
        if ($uri == "cms") {
            $uri = $uri . '/';
        }

        $languages = array_column(\Sinevia\Cms\Helpers\Languages::$data, 0);

        if (strlen(\Request::segment(1)) == 2 AND in_array(\Request::segment(1), $languages)) {
            $uri = substr($uri, 3);
        }

        $alias = \Illuminate\Support\Str::replaceFirst('cms/', '', $uri);

        $page = \Sinevia\Cms\Models\Page::where('Alias', $alias)
                ->orWhere('Alias', '=', '/' . $alias)
                //->where('Status', '=', 'Published')
                ->first();

        if ($page == null) {
            $patterns = array(
                ':any' => '([^/]+)',
                ':num' => '([0-9]+)',
                ':all' => '(.*)',
                ':string' => '([a-zA-Z]+)',
                ':number' => '([0-9]+)',
                ':numeric' => '([0-9-.]+)',
                ':alpha' => '([a-zA-Z0-9-_]+)',
            );
            $aliases = \Sinevia\Cms\Models\Page::pluck('Alias', 'Id')->toArray();
            $aliases = array_filter($aliases, function ($alias) {
                return \Illuminate\Support\Str::contains($alias, [':']);
            });
            foreach ($aliases as $pageId => $alias) {
                $alias = strtr($alias, $patterns);
                if (preg_match('#^' . $alias . '$#', '/' . $uri, $matched)) {
                    $page = \Sinevia\Cms\Models\Page::find($pageId);
                };
            }
            if ($page == null) {
                return 'Page not found';
            }
        }

        $pageTranslation = $page->translation('en');
        if ($pageTranslation == null) {
            die('Page Translation not found ' . $page->Id);
        }
        $pageTitle = $pageTranslation->Title;
        $pageContent = $pageTranslation->Content;
        $pageMetaKeywords = $page->MetaKeywords;
        $pageMetaDescription = $page->MetaDescription;
        $pageMetaRobots = $page->MetaRobots;
        $pageCanonicalUrl = $page->CanonicalUrl != "" ? $page->CanonicalUrl : $page->url();
        $templateId = $page->TemplateId;
        $wysiwyg = $page->Wysiwyg;

        if ($wysiwyg == 'BlockEditor') {
            $blocks = json_decode($pageContent);
            if (is_array($blocks)) {
                $pageContent = $this->blockEditorBlocksToHtml($blocks);
            } else {
                $pageContent = 'Un-blocking error occurred';
            }
        }


        $template = \Sinevia\Cms\Models\Template::find($page->TemplateId);

        if ($template != null) {
            $templateTranslation = $template->translation('en');
            if ($templateTranslation == null) {
                die('Transation for template #' . $template->Id . ' not found');
            }
            $templateContent = $templateTranslation->Content;

            $webpage = \Sinevia\Cms\Helpers\Template::fromString($templateContent, [
                        'page_meta_description' => $pageMetaDescription,
                        'page_meta_keywords' => $pageMetaKeywords,
                        'page_meta_robots' => $pageMetaRobots,
                        'page_canonical_url' => $pageCanonicalUrl,
                        'page_title' => $pageTitle,
                        'page_content' => \Sinevia\Cms\Helpers\Template::fromString($pageContent),
            ]);
        } else {
            $webpage = \Sinevia\Cms\Helpers\Template::fromString($pageContent, [
                        'page' => $page,
                        'pageTranslation' => $pageTranslation,
            ]);
        }


        $webpageRenderedWithBlade = \Sinevia\Cms\Helpers\CmsHelper::blade($webpage);

        $webpageWithBlocks = \Sinevia\Cms\Models\Block::renderBlocks($webpageRenderedWithBlade);
        $webpageWithWidgets = \Sinevia\Cms\Models\Widget::renderWidgets($webpageWithBlocks);
        
        return $webpageWithWidgets;
    }

    function blockEditorBlocksToHtml($blocks) {
        $html = '';
        foreach ($blocks as $block) {
            $type = $block->Type;
            $methodName = 'blockEditorBlock' . $type . 'ToHtml';
            if (method_exists($this, $methodName)) {
                $html .= call_user_func_array([$this, $methodName], [$block]);
            } else {
                $html .= 'Block ' . $type . ' renderer does not exist';
            }
        }
        return $html;
    }

    function blockEditorBlockCodeToHtml($block) {
        $language = $block->Attributes->Language ?? '';
        $code = $block->Attributes->Code ?? '';
        $html = '';
        $html .= '<div class="card">';
        $html .= '  <div class="card-header">Language: ' . ucwords($language) . '</div>';
        $html .= '  <div class="card-body"><pre><code>' . htmlentities($code) . '</code></pre></div>';
        $html .= '</div>';
        return $html;
    }

    function blockEditorBlockHeadingToHtml($block) {
        $level = $block->Attributes->Level ?? 1;
        $text = $block->Attributes->Text ?? '';
        return '<h' . $level . '>' . $text . '</h' . $level . '>';
    }

    function blockEditorBlockImageToHtml($block) {
        $url = $block->Attributes->Url ?? '';
        return '<img src="' . $url . '" class="img img-responsive img-thumbnail" />';
    }

    function blockEditorBlockRawHtmlToHtml($block) {
        $text = $block->Attributes->Text ?? '';
        return $text;
    }

    function blockEditorBlockTextToHtml($block) {
        $text = $block->Attributes->Text ?? '';
        return '<p>' . $text . '</p>';
    }

    function getBlockManager() {
        $view = request('view', '');
        $filterStatus = request('filter_status', '');
        if ($view == 'trash') {
            $filterStatus = 'Deleted';
        }
        if ($filterStatus == 'Deleted') {
            $view = 'trash';
        }
        $session_order_by = \Session::get('cms_block_manager_by', 'Id');
        $session_order_sort = \Session::get('cms_block_manager_sort', 'asc');
        $orderby = request('by', $session_order_by);
        $sort = request('sort');
        $page = request('page', 0);
        $results_per_page = 20;

        if (in_array(strtolower($sort), ["asc", "desc"]) == false) {
            $sort = 'ASC';
        }

        \Session::put('cms_block_manager_by', $orderby); // Keep for session
        \Session::put('cms_block_manager_sort', $sort);  // Keep for session

        $q = \Sinevia\Cms\Models\Block::getModel();

        if ($filterStatus == "") {
            $q = $q->where('Status', '<>', 'Deleted');
        }
        if ($filterStatus != "") {
            $q = $q->where('Status', '=', $filterStatus);
        }

        $q = $q->orderBy($orderby, $sort);
        $blocks = $q->paginate($results_per_page);

        return view('cms::admin/block-manager', get_defined_vars());
    }

    function getBlockUpdate() {
        $blockId = request('BlockId', '');
        $block = \Sinevia\Cms\Models\Block::find($blockId);

        if ($block == null) {
            return redirect()->back()->withErrors('Block not found');
        }

        $block_translations = $block->translations;
        $default_translation = $block->translation('en');

        $content = request('Content', old('Content', $block->Content));
        $status = request('Status', old('Status', $block->Status));
        $title = request('Title', old('Title', $block->Title));

        return view('cms::admin/block-update', get_defined_vars());
    }

    function getPageManager() {
        $view = request('view', '');
        $filterStatus = request('filter_status', '');
        $filterSearch = request('filter_search', '');

        if ($view == 'trash') {
            $filterStatus = 'Deleted';
        }
        if ($filterStatus == 'Deleted') {
            $view = 'trash';
        }

        $session_order_by = \Session::get('cms_page_manager_by', 'Title');
        $session_order_sort = \Session::get('cms_page_manager_sort', 'asc');
        $orderby = request('by', $session_order_by);
        $sort = request('sort', 'ASC');
        $page = request('page', 0);
        $results_per_page = 20;

        if (in_array(strtolower($sort), ["asc", "desc"]) == false) {
            $sort = 'ASC';
        }

        \Session::put('cms_page_manager_by', $orderby); // Keep for session
        \Session::put('cms_page_manager_sort', $sort);  // Keep for session

        $tt = (new \Sinevia\Cms\Models\PageTranslation)->getTableName();
        $pt = (new \Sinevia\Cms\Models\Page)->getTableName();
        $q = \Sinevia\Cms\Models\Page::getModel();
        $q = $q->leftJoin($tt, $pt . '.Id', '=', $tt . '.PageId');

        if ($filterStatus == "") {
            $q = $q->where('Status', '<>', 'Deleted');
        }
        if ($filterStatus != "") {
            $q = $q->where('Status', '=', $filterStatus);
        }
        if ($filterSearch != "") {
            $q = $q->where('Title', 'LIKE', '%' . $filterSearch . '%');
        }

        $q = $q->orderBy($orderby, $sort);
        $pages = $q->select($pt . '.*', $tt . '.Title')
                ->paginate($results_per_page);

        foreach ($pages as $i => $page) {
            $default_translation = $page->translation('en');
            $pages[$i]->Title = $default_translation->Title;
        }

        return view('cms::admin/page-manager', get_defined_vars());
    }

    function getPageUpdate() {
        $page = \Sinevia\Cms\Models\Page::find(request('PageId'));
        if ($page == null) {
            return redirect()->back()->withErrors('Page not found');
        }
        $access = request('Access', old('Access', $page->Access));
        $alias = request('Alias', old('Alias', $page->Alias));
        $canonicalUrl = request('CanonicalUrl', old('CanonicalUrl', $page->CanonicalUrl));
        //$content = request('Content', old('Content', $page->Content));
        $status = request('Status', old('Status', $page->Status));
        //$summary = request('Summary', old('Summary', $page->Summary));
        $templateId = request('TemplateId', old('TemplateId', $page->TemplateId));
        $title = request('Title', old('Title', $page->Title));
        $metaKeywords = request('MetaKeywords', old('MetaKeywords', $page->MetaKeywords));
        $metaDescription = request('MetaDescription', old('MetaDescription', $page->MetaDescription));
        $metaRobots = request('MetaRobots', old('MetaRobots', $page->MetaRobots));
        $wysiwyg = request('Wysiwyg', old('Wysiwyg', $page->Wysiwyg));

        $page_translations = $page->translations;
        $default_translation = $page->translation('en');

        $templateList = \Sinevia\Cms\Models\Template::orderBy('Title')->get();

        $viewLink = $page->url();
        $mediaManagerLink = \Sinevia\Cms\Helpers\Links::adminMediaManager();

        return view('cms::admin/page-update', get_defined_vars());
    }

    function getTemplateManager() {
        $view = request('view', '');
        $filterStatus = request('filter_status', '');
        if ($view == 'trash') {
            $filterStatus = 'Deleted';
        }
        if ($filterStatus == 'Deleted') {
            $view = 'trash';
        }
        $session_order_by = \Session::get('cms_template_manager_by', 'Id');
        $session_order_sort = trim(\Session::get('cms_template_manager_sort', 'asc'));
        $orderby = request('by', $session_order_by);
        $sort = request('sort', $session_order_sort);
        $page = request('page', 0);
        $results_per_page = 20;
        if (in_array(strtolower($sort), ['asc', 'desc']) == false) {
            $sort = 'asc';
        }
        \Session::put('cms_template_manager_by', $orderby); // Keep for session
        \Session::put('cms_template_manager_sort', $sort);  // Keep for session

        $q = \Sinevia\Cms\Models\Template::getModel();

        if ($filterStatus == "") {
            $q = $q->where('Status', '<>', 'Deleted');
        }
        if ($filterStatus != "") {
            $q = $q->where('Status', '=', $filterStatus);
        }

        $q = $q->orderBy($orderby, $sort);
        $templates = $q->paginate($results_per_page);

        return view('cms::admin/template-manager', get_defined_vars());
    }

    function getTemplateUpdate() {
        $template = \Sinevia\Cms\Models\Template::find(request('TemplateId'));

        if ($template == null) {
            return redirect()->back()->withErrors('Template not found');
        }

        $template_translations = $template->translations;
        $default_translation = $template->translation('en');

        $content = request('Content', old('Content', $template->Content));
        $status = request('Status', old('Status', $template->Status));
        $title = request('Title', old('Title', $template->Title));

        return view('cms::admin/template-update', get_defined_vars());
    }

    function getTranslationManager() {
        $view = request('view', '');
        $filterStatus = request('filter_status', '');
        if ($view == 'trash') {
            $filterStatus = 'Deleted';
        }
        if ($filterStatus == 'Deleted') {
            $view = 'trash';
        }
        $session_order_by = \Session::get('cms_page_translation_by', 'Key');
        $session_order_sort = \Session::get('cms_page_translation_sort', 'asc');
        $orderby = request('by', $session_order_by);
        $sort = request('sort');
        $page = request('page', 0);
        $results_per_page = 20;

        if (in_array(strtolower($sort), ["asc", "desc"]) == false) {
            $sort = 'ASC';
        }

        \Session::put('cms_translation_manager_by', $orderby); // Keep for session
        \Session::put('cms_translation_manager_sort', $sort);  // Keep for session

        $q = \Sinevia\Cms\Models\TranslationKey::getModel();

        if ($filterStatus == "") {
            //$q = $q->where('Status', '<>', 'Deleted');
        }
        if ($filterStatus != "") {
            //$q = $q->where('Status', '=', $filterStatus);
        }
        $q = $q->orderBy($orderby, $sort);
        $translationKeys = $q->paginate($results_per_page);

        foreach ($translationKeys as $i => $translationKey) {
            //$default_translation = $page->translation('en');
            //$pages[$i]->Title = $default_translation->Title;
        }

        return view('cms::admin/translation-manager', get_defined_vars());
    }

    function getTranslationUpdate() {
        $translationKey = \Sinevia\Cms\Models\TranslationKey::find(request('TranslationId'));

        if ($translationKey == null) {
            return redirect()->back()->withErrors('Translation not found');
        }

        $translationValues = \Sinevia\Cms\Models\TranslationValue::where('KeyId', $translationKey->Id)->get();
        $defaultValue = \Sinevia\Cms\Models\TranslationValue::where('KeyId', $translationKey->Id)->where('Language', 'en')->first();

        $key = request('Key', old('Key', $translationKey->Key));

        return view('cms::admin/translation-update', get_defined_vars());
    }

    function getWidgetManager() {
        $view = request('view', '');
        $filterStatus = request('filter_status', 'not_deleted');
        if ($view == 'trash') {
            $filterStatus = 'Deleted';
        }
        if ($filterStatus == 'Deleted') {
            $view = 'trash';
        }
        $session_order_by = \Session::get('cms_widget_manager_by', 'Id');
        $session_order_sort = \Session::get('cms_widget_manager_sort', 'asc');
        $orderby = request('by', $session_order_by);
        $sort = request('sort');
        $page = request('page', 0);
        $results_per_page = 20;

        if (in_array(strtolower($sort), ["asc", "desc"]) == false) {
            $sort = 'ASC';
        }

        \Session::put('cms_widget_manager_by', $orderby); // Keep for session
        \Session::put('cms_widget_manager_sort', $sort);  // Keep for session

        $q = \Sinevia\Cms\Models\Widget::getModel();
        $q = $q->orderBy($orderby, $sort);
        $widgets = $q->paginate($results_per_page);

        return view('cms::admin/widget-manager', get_defined_vars());
    }

    function getWidgetUpdate() {
        $widget = \Sinevia\Cms\Models\Widget::find(request('WidgetId'));
        if ($widget == null) {
            return redirect('Admin\CmsController@getWidgetManager')->withErrors('Widget not found');
        }
        $content = request('Content', old('Content', $widget->Content));
        $title = request('Title', old('Title', $widget->Title));
        $status = request('Status', old('Status', $widget->Status));
        $parameters = request('Parameters', old('Parameters', json_decode($widget->Parameters, true)));
        $cache = request('Cache', old('Cache', $widget->Cache));
        $type = request('Type', old('Type', $widget->Type));

        $widgetsDirectory = \Sinevia\Cms\Models\Widget::path();

        if ($widgetsDirectory == '') {
            return back()->withErrors('Widgets directory not recognized. Is it set in the CMS configuration settings?');
        }

        if (is_dir($widgetsDirectory) == false) {
            return back()->withErrors('Widgets directory does not exist. Is it a valid directory set in the CMS configuration settings?');
        }

        $types = \Sinevia\Cms\Helpers\CmsHelper::directoryListDirectories(resource_path('widgets'));
        $parametersFormUrl = \Sinevia\Cms\Helpers\Links::adminWidgetPatametersFormAjax();

        return view('cms::admin/widget-update', get_defined_vars());
    }

    function anyWidgetParametersFormAjax() {
        $type = trim(request('Type', ''));
        if ($type == "") {
            return 'Please, select a Type for this widget';
        }
        $widgetPath = resource_path('widgets/' . $type);
        if (file_exists($widgetPath) == false) {
            return 'Error. Widget not found';
        }
        $parametersFormPath = $widgetPath . '/parameters.phtml';
        if (file_exists($parametersFormPath) == false) {
            return 'Error. No parameters found';
        }
        return \Sinevia\Cms\Helpers\Template::fromFile($parametersFormPath);
    }

    function postBlockCreate() {
        $rules = array(
            'Title' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Request::all());
        }

        $title = request('Title', '');

        \DB::beginTransaction();
        try {
            $block = new \Sinevia\Cms\Models\Block;
            $block->Title = $title;
            $block->Status = 'Draft';
            $block->CreatedAt = date('Y-m-d H:i:s');
            $block->UpdatedAt = date('Y-m-d H:i:s');

            $result = $block->save();

            $translation = new \Sinevia\Cms\Models\BlockTranslation;
            $translation->BlockId = $block->Id;
            $translation->Language = 'en';
            $translation->Content = '';
            $translation->save();

            if ($result == false) {
                return \Redirect::back()->withErrors('Block failed to be saved.')->withInput(\Request::all());
            }

            \DB::commit();

            $redirectUrl = \Sinevia\Cms\Helpers\Links::adminBlockUpdate(['BlockId' => $block->Id]);
            return \Redirect::to($redirectUrl)->withSuccess('Block successfully saved.');
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Block failed to be created";
            return \Redirect::back()->withErrors($error)->withInput(\Request::all());
        }
    }

    function postBlockDelete() {
        $blockId = request('BlockId', '');
        $block = \Sinevia\Cms\Models\Block::find($blockId);
        if ($block == null) {
            return redirect()->back()->withErrors('Block not found');
        }
        $block->Status = 'Deleted';
        $block->save();
        return redirect()->back();
    }

    function postBlockTranslationCreate() {
        /* START: Data */
        $blockId = request('BlockId', '');
        $language = request('Language', '');
        $content = request('Content', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        $block = \Sinevia\Cms\Models\Block::find($blockId);

        if ($block == null) {
            return redirect()->back()->withErrors('Block with ID ' . $blockId . ' DOES NOT exist', action('Admin\CmsController@getBlockManager'));
        }

        $translation = $block->translation($language);

        if ($translation != null) {
            return \Redirect::back()->withErrors($language_name . ' translation already exists');
        }

        $translation = new \Sinevia\Cms\Models\BlockTranslation();
        $translation->BlockId = $blockId;
        $translation->Language = $language;
        $translation->Content = '';

        if ($translation->save()) {
            return \Redirect::back()->with('success', 'Your successuly created ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be created.');
    }

    function postBlockTranslationDelete() {
        /* START: Data */
        $blockId = request('BlockId', '');
        $language = request('Language', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        if ($blockId == '') {
            return redirect()->back()->withErrors('Template ID missing');
        }
        $block = \Sinevia\Cms\Models\Block::find($blockId);

        if ($block == null) {
            return $this->flashError('Block with ID ' . $blockId . ' DOES NOT exist', action('Admin\CmsController@getBlockManager'));
        }

        $translation = $block->translation($language);

        if ($translation == null) {
            return \Redirect::back()->withErrors($language_name . ' translation already removed');
        }

        if ($language == 'en') {
            return \Redirect::back()->withErrors('English is default translation and cannot be removed');
        }

        if ($translation->delete()) {
            $url = action('Admin\CmsController@getBlockUpdate') . '?BlockId=' . $blockId;
            return \Redirect::to($url)->with('success', 'Your successuly deleted ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be deleted.');
    }

    function postBlockUpdate() {
        $blockId = request('BlockId', '');
        $block = \Sinevia\Cms\Models\Block::find($blockId);
        if ($block == null) {
            return redirect()->back()->withErrors('Block not found');
        }

        $rules = array(
            'Status' => 'required', // required
            'Title' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $action = request('action', '');
        //$content = request('Content', $template->Content);
        $content = request('Content', []);
        $status = request('Status', $block->Status);
        $title = request('Title', $block->Title);
        $translations = $block->translations;

        \DB::beginTransaction();
        try {
            $block->Status = $status;
            $block->Title = $title;
            $block->save();

            $block->save();

            foreach ($translations as $tr) {
                $language = $tr['Language'];
                $tr->Content = $content[$language];
                $tr->save();
            }

            $result = \DB::commit();

            if ($result !== false) {
                if ($action === 'save') {
                    \Session::flash('success', 'You successuly updated the block');
                    return redirect()->back();
                }
                \Session::flash('success', 'You successuly updated the block');
                return redirect(\Sinevia\Cms\Helpers\Links::adminBlockManager());
            }
        } catch (Exception $e) {
            \DB::rollback();
        }

        return redirect()->back()->withErrors('Saving the template FAILED...')->withInput();
    }

    function postPageCreate() {
        $rules = array(
            'Title' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Request::all());
        }

        $title = request('Title', '');

        $page = new \Sinevia\Cms\Models\Page;
        $page->Status = 'Draft';
        $page->Alias = '/' . \Illuminate\Support\Str::slug($title) . '-' . uniqid(); // Unique for now

        if ($page->save() === false) {
            return redirect()->back()->withErrors('Page COULD NOT be created');
        }

        $translation = new \Sinevia\Cms\Models\PageTranslation();
        $translation->PageId = $page->Id;
        $translation->Language = 'en';
        $translation->Title = $title;
        $translation->Summary = '';
        $translation->Content = '';

        if ($translation->save() === false) {
            return \Redirect::back()->with('success', 'Page translation COULD NOT be created.');
        }

        return redirect(\Sinevia\Cms\Helpers\Links::adminPageUpdate(['PageId' => $page->Id]))
                        ->withSuccess('Page successfully created');
    }

    function postPageDelete() {
        $page = \Sinevia\Cms\Models\Page::find(request('PageId'));
        if ($page == null) {
            return \Redirect::back()->withErrors('Page not found');
        }
        \DB::beginTransaction();
        try {
            /* Move to Trash */
            $page->Status = 'Deleted';
            $page->save();
            /* Delete */
            $translations = \Sinevia\Cms\Models\PageTranslation::where('PageId', $page->Id)->delete();
            $page->delete();

            \DB::commit();

            return \Redirect::back();
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Page COULD NOT be deleted";
            return \Redirect::back()->withErrors($error);
        }
    }

    function postPageMoveToTrash() {
        $page = \Sinevia\Cms\Models\Page::find(request('PageId'));
        if ($page == null) {
            return redirect()->back()->withErrors('Page not found');
        }
        \DB::beginTransaction();
        try {
            $page->Status = 'Deleted';
            $page->save();

            \DB::commit();
            return redirect()->back();
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Template COULD NOT be deleted";
            return \Redirect::back()->withErrors($error);
        }
    }

    function postPageTranslationCreate() {
        /* START: Data */
        $pageId = request('PageId', '');
        $language = request('Language', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        $rules = array(
            'PageId' => 'required', // required
            'Language' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $page = \Sinevia\Cms\Models\Page::find($pageId);

        if ($page == null) {
            return redirect()->back()->withErrors('Page with ID ' . $pageId . ' DOES NOT exist');
        }

        $translation = $page->translation($language);

        if ($translation != null) {
            return \Redirect::back()->withErrors($language_name . ' translation already exists');
        }

        $translation = new \Sinevia\Cms\Models\PageTranslation();
        $translation->PageId = $pageId;
        $translation->Language = $language;
        $translation->Summary = '';
        $translation->Content = '';

        if ($translation->save()) {
            return \Redirect::back()->with('success', 'Your successuly created ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be created.');
    }

    function postPageTranslationDelete() {
        /* START: Data */
        $pageId = request('PageId', '');
        $language = request('Language', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        if ($pageId == '') {
            return $this->flashError('Page ID missing');
        }
        $page = \Sinevia\Cms\Models\Template::find($pageId);

        if ($page == null) {
            return \Redirect::back()->withErrors('Page with ID ' . $pageId . ' DOES NOT exist');
        }

        $translation = $page->translation($language);

        if ($translation == null) {
            return \Redirect::back()->withErrors($language_name . ' translation already removed');
        }

        if ($language == 'en') {
            return \Redirect::back()->withErrors('English is default translation and cannot be removed');
        }

        if ($translation->delete()) {
            $url = \Sinevia\Cms\Helpers\Links::adminPageUpdate(['PageId' => $pageId]);
            return \Redirect::to($url)->with('success', 'Your successuly deleted ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be deleted.');
    }

    function postPageUpdate() {
        $page = \Sinevia\Cms\Models\Page::find(request('PageId'));
        if ($page == null) {
            return \Redirect::back()->withErrors('Page not found');
        }

        $rules = array(
            'Status' => 'required', // required
            'Title' => 'required', // required
            'Alias' => 'required', // required
//                'Alias' => 'required|unique:snv_cms_page', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $action = request('action', '');
        $access = request('Access', $page->Access);
        $alias = request('Alias', $page->Alias);
        //$content = request('Content', $page->Content);
        $content = request('Content', []);
        $status = request('Status', $page->Status);
        //$summary = request('Summary', $page->Summary);
        $summary = request('Summary', []);
        $templateId = request('TemplateId', $page->TemplateId);
        //$title = request('Title', $page->Title);
        $title = request('Title', []);
        $metaKeywords = request('MetaKeywords', $page->MetaKeywords);
        $metaDescription = request('MetaDescription', $page->MetaDescription);
        $metaRobots = request('MetaRobots', $page->MetaRobots);
        $canonicalUrl = request('CanonicalUrl', $page->CanonicalUrl);
        $wysiwyg = request('Wysiwyg', $page->Wysiwyg);

        $translations = $page->translations;

        \DB::beginTransaction();
        try {
            $page->Status = $status;
            $page->Access = $access;
            $page->Alias = $alias;
            $page->CanonicalUrl = $canonicalUrl;
            //$page->Content = $content;
            //$page->Summary = $summary;
            $page->MetaKeywords = $metaKeywords;
            $page->MetaDescription = $metaDescription;
            $page->MetaRobots = $metaRobots;
            //$page->Title = $title;
            $page->TemplateId = $templateId;
            $page->Wysiwyg = $wysiwyg;
            $page->save();

            foreach ($translations as $tr) {
                $language = $tr['Language'];
                $tr->Title = $title[$language];
                $tr->Summary = $summary[$language];
                $tr->Content = $content[$language];
                $tr->save();
            }

            $result = \DB::commit();

            if ($result !== false) {
                if ($action === 'save') {
                    \Session::flash('success', 'You successuly updated the page');
                    return redirect()->back();
                }
                \Session::flash('success', 'You successuly updated the page');
                return redirect(\Sinevia\Cms\Helpers\Links::adminPageManager());
            }
        } catch (Exception $e) {
            \DB::rollback();
        }

        return redirect()->back()->withErrors('Saving the page FAILED...')->withInput();
    }

    function postTemplateCreate() {
        $rules = array(
            'Title' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Request::all());
        }

        $title = request('Title', '');

        \DB::beginTransaction();
        try {
            $template = new \Sinevia\Cms\Models\Template;
            $template->Title = $title;
            $template->Status = 'Draft';
            $template->CreatedAt = date('Y-m-d H:i:s');
            $template->UpdatedAt = date('Y-m-d H:i:s');

            $result = $template->save();

            $translation = new \Sinevia\Cms\Models\TemplateTranslation;
            $translation->TemplateId = $template->Id;
            $translation->Language = 'en';
            $translation->Content = '';
            $translation->save();

            if ($result == false) {
                return \Redirect::back()->withErrors('Template failed to be saved.')->withInput(\Request::all());
            }

            \DB::commit();

            $redirectUrl = \Sinevia\Cms\Helpers\Links::adminTemplateUpdate(['TemplateId' => $template->Id]);
            return \Redirect::to($redirectUrl)->withSuccess('Template successfully saved.');
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Template failed to be created";
            return \Redirect::back()->withErrors($error)->withInput(\Request::all());
        }
    }

    function postTemplateMoveToTrash() {
        $template = \Sinevia\Cms\Models\Template::find(request('TemplateId'));
        if ($template == null) {
            return redirect('Admin\CmsController@getTemplateManager')->withErrors('Template not found');
        }
        \DB::beginTransaction();
        try {
            $template->Status = 'Deleted';
            $template->save();

            \DB::commit();
            return redirect()->back();
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Template COULD NOT be deleted";
            return \Redirect::back()->withErrors($error);
        }
    }

    function postTemplateDelete() {
        $template = \Sinevia\Cms\Models\Template::find(request('TemplateId'));
        if ($template == null) {
            return \Redirect::back()->withErrors('Template not found');
        }
        \DB::beginTransaction();
        try {
            $template->Status = 'Deleted';
            $template->save();
            $translations = \Sinevia\Cms\Models\TemplateTranslation::where('TemplateId', $template->Id)->delete();
            $template->delete();

            \DB::commit();
            return redirect()->back();
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Template COULD NOT be deleted";
            return \Redirect::back()->withErrors($error);
        }
    }

    function postTemplateTranslationCreate() {
        /* START: Data */
        $templateId = request('TemplateId', '');
        $language = request('Language', '');
        $content = request('Content', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        if ($templateId == '') {
            return $this->flashError('Page ID missing');
        }

        $template = \Sinevia\Cms\Models\Template::find($templateId);

        if ($template == null) {
            return $this->flashError('Template with ID ' . $templateId . ' DOES NOT exist', action('Admin\CmsController@getTemplateManager'));
        }

        $translation = $template->translation($language);

        if ($translation != null) {
            return \Redirect::back()->withErrors($language_name . ' translation already exists');
        }

        $translation = new \Sinevia\Cms\Models\TemplateTranslation();
        $translation->TemplateId = $templateId;
        $translation->Language = $language;
        $translation->Content = '';

        if ($translation->save()) {
            return \Redirect::back()->with('success', 'Your successuly created ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be created.');
    }

    function postTemplateTranslationDelete() {
        /* START: Data */
        $templateId = request('TemplateId', '');
        $language = request('Language', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        if ($templateId == '') {
            return $this->flashError('Template ID missing');
        }
        $template = \Sinevia\Cms\Models\Template::find($templateId);

        if ($template == null) {
            return $this->flashError('Template with ID ' . $templateId . ' DOES NOT exist', action('Admin\CmsController@getTemplateManager'));
        }

        $translation = $template->translation($language);

        if ($translation == null) {
            return \Redirect::back()->withErrors($language_name . ' translation already removed');
        }

        if ($language == 'en') {
            return \Redirect::back()->withErrors('English is default translation and cannot be removed');
        }

        if ($translation->delete()) {
            $url = action('Admin\CmsController@getPageUpdate') . '?PageId=' . $pageId;
            return \Redirect::to($url)->with('success', 'Your successuly deleted ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be deleted.');
    }

    function postTemplateUpdate() {
        $template = \Sinevia\Cms\Models\Template::find(request('TemplateId'));
        if ($template == null) {
            return \Redirect::back()->withErrors('Template not found');
        }

        $rules = array(
            'Status' => 'required', // required
            'Title' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $action = request('action', '');
        //$content = request('Content', $template->Content);
        $content = request('Content', []);
        $status = request('Status', $template->Status);
        $title = request('Title', $template->Title);
        $translations = $template->translations;

        \DB::beginTransaction();
        try {
            $template->Status = $status;
            $template->Title = $title;
            $template->save();

            $template->save();

            foreach ($translations as $tr) {
                $language = $tr['Language'];
                $tr->Content = $content[$language];
                $tr->save();
            }

            $result = \DB::commit();

            if ($result !== false) {
                if ($action === 'save') {
                    \Session::flash('success', 'You successuly updated the template');
                    return redirect()->back();
                }
                \Session::flash('success', 'You successuly updated the template');
                return redirect(\Sinevia\Cms\Helpers\Links::adminTemplateManager());
            }
        } catch (Exception $e) {
            \DB::rollback();
        }

        return redirect()->back()->withErrors('Saving the template FAILED...')->withInput();
    }

    function postTranslationCreate() {
        $rules = array(
            'Key' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Request::all());
        }

        $key = request('Key', '');

        \DB::beginTransaction();
        try {
            $translationKey = new \Sinevia\Cms\Models\TranslationKey;
            $translationKey->Key = $key;

            $result = $translationKey->save();

            $translationValue = new \Sinevia\Cms\Models\TranslationValue;
            $translationValue->KeyId = $translationKey->Id;
            $translationValue->Language = 'en';
            $translationValue->Value = '';
            $translationValue->save();

            if ($result == false) {
                return \Redirect::back()->withErrors('Translation failed to be saved.')->withInput(\Request::all());
            }

            \DB::commit();

            return \Redirect::back()->withSuccess('Translation successfully saved.');
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Translation failed to be created";
            return \Redirect::back()->withErrors($error)->withInput(\Request::all());
        }
    }

    function postTranslationDelete() {
        $translationKey = \Sinevia\Cms\Models\TranslationKey::find(request('TranslationId'));
        if ($translationKey == null) {
            return \Redirect::back()->withErrors('Translation not found');
        }
        \DB::beginTransaction();
        try {
            \Sinevia\Cms\Models\TranslationValue::where('KeyId', $translationKey->Id)->delete();
            $translationKey->delete();

            \DB::commit();
            return redirect()->back();
        } catch (Exception $e) {
            \DB::rollback();
            $error = "Translation COULD NOT be deleted";
            return \Redirect::back()->withErrors($error);
        }
    }

    function postTranslationUpdate() {
        $translationKey = \Sinevia\Cms\Models\TranslationKey::find(request('TranslationId'));
        if ($translationKey == null) {
            return \Redirect::back()->withErrors('Translation not found');
        }
        $rules = array(
            'Key' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $action = request('action', '');
        $content = request('Content', []); // Values content
        $key = request('Key', $translationKey->Key);
        $translationValues = \Sinevia\Cms\Models\TranslationValue::where('KeyId', $translationKey->Id)->get();

        \DB::beginTransaction();
        try {
            $translationKey->Key = $key;
            $translationKey->save();

            foreach ($translationValues as $tr) {
                $language = $tr['Language'];
                $tr->Value = $content[$language];
                $tr->save();
            }

            $result = \DB::commit();

            if ($result !== false) {
                if ($action === 'save') {
                    \Session::flash('success', 'You successuly updated the translation');
                    return redirect()->back();
                }
                \Session::flash('success', 'You successuly updated the translation');
                return redirect(\Sinevia\Cms\Helpers\Links::adminTranslationManager());
            }
        } catch (Exception $e) {
            \DB::rollback();
        }

        return redirect()->back()->withErrors('Saving the translation FAILED...')->withInput();
    }

    function postTranslationValueCreate() {
        $rules = array(
            'KeyId' => 'required', // required
            'Language' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        /* START: Data */
        $keyId = request('KeyId', '');
        $language = request('Language', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        $translationKey = \Sinevia\Cms\Models\TranslationKey::find($keyId);

        if ($translationKey == null) {
            return redirect()->back()->withErrors('Translation with ID ' . $keyId . ' DOES NOT exist');
        }

        $translationValue = \Sinevia\Cms\Models\TranslationValue::where('KeyId', $keyId)->where('Language', $language)->first();

        if ($translationValue != null) {
            return \Redirect::back()->withErrors($language_name . ' translation already exists');
        }

        $translationValue = new \Sinevia\Cms\Models\TranslationValue();
        $translationValue->KeyId = $keyId;
        $translationValue->Language = $language;
        $translationValue->Value = '';

        if ($translationValue->save()) {
            return \Redirect::back()->with('success', 'Your successuly created ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be created.');
    }

    function postTranslationValueDelete() {
        $rules = array(
            'KeyId' => 'required', // required
            'Language' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Request::all());
        }

        /* START: Data */
        $keyId = request('KeyId', '');
        $language = request('Language', '');
        $language_name = \Sinevia\Cms\Helpers\Languages::getLanguageByIso1($language);
        /* END: Data */

        $translationKey = \Sinevia\Cms\Models\TranslationKey::find($keyId);

        if ($translationKey == null) {
            return redirect()->back()->withErrors('Translation with ID ' . $keyId . ' DOES NOT exist');
        }

        $translationValue = \Sinevia\Cms\Models\TranslationValue::where('KeyId', $keyId)->where('Language', $language)->first();

        if ($language == 'en') {
            return \Redirect::back()->withErrors('English is default translation and cannot be removed');
        }

        if ($translationValue->delete()) {
            return \Redirect::back()->with('success', 'Your successuly deleted ' . $language_name . ' translation.');
        }

        return \Redirect::back()->withErrors($language_name . ' translation FAILED to be deleted.');
    }

    function postWidgetCreate() {
        $rules = array(
            'Title' => 'required', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return \Redirect::back()->withErrors($validator)->withInput(\Request::all());
        }

        $widget = new \Sinevia\Cms\Models\Widget;
        $widget->Status = 'Draft';
        $widget->Title = request('Title');
        $widget->Type = trim(request('Type', ''));
        $widget->Parameters = json_encode(request('Parameters', []));

        if ($widget->save() !== false) {
            return redirect(\Sinevia\Cms\Helpers\Links::adminWidgetUpdate(['WidgetId' => $widget->Id]))
                            ->withSuccess('Widget successfully created');
        }

        return redirect()->back()->withErrors('Wdget COULD NOT be created');
    }

    function postWidgetDelete() {
        $widget = \Sinevia\Cms\Models\Widget::find(request('WidgetId'));
        if ($widget == null) {
            return redirect()->back()->withErrors('Widget not found');
        }

        $widget->Status = 'Deleted';
        $widget->save();
        return redirect()->back();
    }

    function postWidgetUpdate() {
        $widget = \Sinevia\Cms\Models\Widget::find(request('WidgetId'));
        if ($widget == null) {
            return redirect()->back()->withErrors('Widget not found');
        }

        $rules = array(
            'Status' => 'required', // required
            'Title' => 'required', // required
            'Parameters' => 'required|array', // required
        );

        $validator = \Validator::make(\Request::all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $action = request('action', '');
        $content = request('Content', $widget->Content);
        $status = request('Status', $widget->Status);
        $title = request('Title', $widget->Title);
        $parameters = request('Parameters', $widget->Parameters);
        $type = request('Type', $widget->Type);

        \DB::beginTransaction();
        try {
            $widget->Status = $status;
            //$widget->Content = $content;
            $widget->Title = $title;
            $widget->Parameters = json_encode($parameters);
            $widget->Type = $type;
            $widget->save();

            $result = \DB::commit();

            if ($result !== false) {
                if ($action === 'save') {
                    \Session::flash('success', 'You successuly updated the widget');
                    return redirect()->back();
                }
                \Session::flash('success', 'You successuly updated the widget');
                return redirect(\Sinevia\Cms\Helpers\Links::adminWidgetManager());
            }
        } catch (Exception $e) {
            \DB::rollback();
        }

        return redirect()->back()->withErrors('Saving the widget FAILED...')->withInput();
    }

}
