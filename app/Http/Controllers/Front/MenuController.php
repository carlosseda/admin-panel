<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\HtmlString;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Models\DB\Menu;
use Config;

class MenuController extends Controller
{
    
    public function displayMenu($menu_name)
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
                        'menu_name' => $menu_name,
                    ])->render()
                );
            }
            
            if($agent->isMobile()){
                return new \Illuminate\Support\HtmlString(
                    View::make('front.components.mobile.custom_menu_mobile', [
                        'items' => $items,
                        'menu_name' => $menu_name,
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
                $item->url = $item->localeSeo->key; 

                // if($item->parent_id == null && isset($item->image->first()->name)){

                //     $item->featured_image = $item->image;
                // }
            }
    
            if(!$item->children->isEmpty()){
                $this->getItems($item->children);
            }
        }

        return $items;
    }
}
