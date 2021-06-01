<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MenuRequest;
use Jenssegers\Agent\Agent;
use App\Models\DB\Menu;
use App\Models\DB\MenuItem;
use App\Vendor\Locale\Models\LocaleSeo;
use App\Vendor\Locale\LocaleSlugSeo;

class MenuController extends Controller
{
    protected $agent;
    protected $menu;
    protected $item;
    protected $locale_seo;
    protected $locale_slug_seo;    
    protected $paginate;

    function __construct(Menu $menu, Agent $agent, MenuItem $menu_item, LocaleSeo $locale_seo, LocaleSlugSeo $locale_slug_seo)
    {
        $this->middleware('auth');
        $this->agent = $agent;
        $this->menu = $menu;
        $this->menu_item = $menu_item;
        $this->locale_seo = $locale_seo;
        $this->locale_slug_seo = $locale_slug_seo;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }
    }

    public function index()
    {
        $view = View::make('admin.menus.index')
            ->with('menu', $this->menu)
            ->with('menus', $this->menu->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate($this->paginate));

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }

        return $view;
    }

    public function create()
    {

        $view = View::make('admin.menus.index')
        ->with('menu', $this->menu)
        ->renderSections();

        return response()->json([
            'form' => $view['form'],
        ]);
    }

    public function store(MenuRequest $request)
    {           

        $menu = Menu::updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'active' => 1,
        ]);
        
        if (request('id')){
            $message = \Lang::get('admin/menus.menu-update');
        }else{
            $message = \Lang::get('admin/menus.menu-create');
        }

        $sections = $this->locale_seo->where('menu', 1)->get();
        $links = $this->locale_slug_seo->getAll();     

        $view = View::make('admin.menus.index')
        ->with('menu', $menu)
        ->with('menu_item', $this->menu_item)
        ->with('sections', $sections)
        ->with('links', $links)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $menu->id,
            'message' => $message,
        ]);
    }

    public function edit(Menu $menu)
    {

        $sections = $this->locale_seo->where('menu', 1)->get();
        $links = $this->locale_slug_seo->getAll();     
                        
        $view = View::make('admin.menus.index')
        ->with('menu', $menu)
        ->with('menu_item', $this->menu_item)
        ->with('sections', $sections)
        ->with('links', $links);
        
        if(request()->ajax()) {
            
            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(Menu $menu)
    {

        $menu->delete();

        $message = \Lang::get('admin/menus.menu-delete');    

        $view = View::make('admin.menus.index')
            ->with('crud_permissions', $this->crud_permissions)
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message,
        ]);
    }
}
