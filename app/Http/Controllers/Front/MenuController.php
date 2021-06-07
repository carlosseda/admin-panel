<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Models\DB\Menu;

class MenuController extends Controller
{
    
    public function displayMenu($menu_name, $type)
    {
        $language = app()->getLocale();
        $agent = new Agent();

        $menu = Menu::where('name', '=', $menu_name)
        ->with(['parent_items'=> function ($q) use ($language) {
            $q->where('language', $language)->with('children');
        }])->first();
                
        if (isset($menu)) {

            $items = $this->getItems($menu->parent_items);

            if($agent->isDesktop()){
                return new \Illuminate\Support\HtmlString(
                    View::make('front.components.desktop.custom_menu', [
                        'items' => $items,
                        'type' => $type
                    ])->render()
                );
            }
            
            if($agent->isMobile()){
                return new \Illuminate\Support\HtmlString(
                    View::make('front.components.mobile.custom_menu_mobile', [
                        'items' => $items,
                        'type' => $type
                    ])->render()
                );
            }

        }else{
            return false;
        }
    }

    public function getItems($items){

        foreach($items as $item){
            
            if($item->locale_seo_id != null){
                
                $item->custom_url = $item->localeSeo->url; 
            }
    
            if(!$item->children->isEmpty()){
                $this->getItems($item->children);
            }
        }

        return $items;
    }
}
