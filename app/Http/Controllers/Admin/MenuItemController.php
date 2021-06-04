<?php

namespace  App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vendor\Image\Image;
use App\Http\Requests\Admin\MenuItemRequest;
use App\Models\DB\MenuItem;
use App\Vendor\Locale\Models\LocaleSeo;
use App\Vendor\Locale\Models\LocaleSlugSeo;
use Route;
use Debugbar;

class MenuItemController extends Controller
{
    protected $locale_seo;
    protected $locale_slug_seo;
    protected $menu_item;

    function __construct(MenuItem $menu_item, LocaleSeo $locale_seo, LocaleSlugSeo $locale_slug_seo)
    {
        $this->middleware('auth');
        
        $this->menu_item = $menu_item;
        $this->locale_seo = $locale_seo;
        $this->locale_slug_seo = $locale_slug_seo;
    }

    public function index(Request $request, $language = null, $item = null)
    {
        $menu_items = $this->menu_item
                ->where('language', $language)
                ->where('menu_id', $item)
                ->get();

        if(request()->ajax()) {
    
            return response()->json([
                'items' => $menu_items,
            ]); 
        }
    }

    public function create(Request $request, $language = null)
    {

        $sections = $this->locale_seo->where('menu', 1)->where('language',  $request->input('language'))->get();
        $links = $this->locale_slug_seo->where('language',  $request->input('language'))->get();
        
        $view = View::make('admin.components.modal_menu_item')
        ->with('sections', $sections)
        ->with('links', $links)
        ->render();
        
        if(request()->ajax()) {
    
            return response()->json([
                'form' => $view,
            ]); 
        }
    }

    public function store(MenuItemRequest $request)
    {

        $item = MenuItem::updateOrCreate([
            'id' => request('id'),
            'language' => request('language')],[
            'locale_seo_id' =>  request('locale_seo_id'),
            'locale_slug_seo_id' => request('locale_slug_seo_id'),
            'name' => request('name'),
            'description' => request('description'),
            'custom_url' => remove_protocol(request('custom_url')),
            'menu_id' => request('menu_id'),
        ]);

        $sections = $this->locale_seo->where('menu', 1)->where('language',  $item->language)->get();
        $links = $this->locale_slug_seo->where('language', $item->language)->get();

        if (request('id')){
            $message = \Lang::get('admin/menu_items.menu-items-update');
        }else{
            $message = \Lang::get('admin/menu_items.menu-items-create');
        }

        $view = View::make('admin.menu_items.index')
            ->with('menu', $item->menu)
            ->with('menu_item', $this->menu_item)
            ->with('sections', $sections)
            ->with('links', $links)
            ->render();
        
        return response()->json([
            'form' => $view,
            'message' => $message,
        ]);
    }

    public function edit(MenuItem $item)
    {

        $sections = $this->locale_seo->where('menu', 1)->where('language',  $item->language)->get();
        $links = $this->locale_slug_seo->where('language', $item->language)->get();
       
        $view = View::make('admin.components.modal_menu_item')
        ->with('menu', $item->menu)
        ->with('menu_item', $item)
        ->with('sections', $sections)
        ->with('links', $links)
        ->render();
        
        if(request()->ajax()) {
    
            return response()->json([
                'form' => $view,
            ]); 
        }
    }

    public function destroy(MenuItem $item)
    {
        $this->menu_item->where('parent_id', $item->id)->update(array('parent_id' => null));
        $item->delete(); 

        $message = \Lang::get('admin/menu_items.menu-items-delete');

        $sections = $this->locale_seo->where('menu', 1)->get();
        $links = $this->locale_slug_seo->getAll();
        
        $view = View::make('admin.menus.index')
            ->with('menu', $item->menu)
            ->with('menu_item', $this->menu_item)
            ->with('sections', $sections)
            ->with('links', $links)
            ->renderSections();
        
        return response()->json([
            'form' => $view['form'],
            'message' => $message,
        ]);
    }

    public function orderItem(Request $request)
    {

        $menu_item_order = json_decode($request->getContent());

        foreach ($menu_item_order as $menu_item) {

            $item = MenuItem::findOrFail($menu_item->id);

            $item->order = $menu_item->order;

            if(isset($menu_item->parent_id)){
                $item->parent_id = $menu_item->parent_id;
            }else{
                $item->parent_id = null;
            }

            $item->save();
        }
    }
}
