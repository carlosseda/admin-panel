<?php

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\DB;
use App\Vendor\Locale\Models\LocaleLanguage;
// use App\Http\Controllers\Admin\MenuController as AdminMenuController;
// use App\Http\Controllers\Front\MenuController as FrontMenuController;


if ( ! function_exists('slug_helper'))
{
    function slug_helper($string)
    {
        $string = htmlentities($string, ENT_COMPAT, "UTF-8", false); 
        $string = preg_replace('/&([a-z]{1,2})(?:acute|circ|lig|grave|ring|tilde|uml|cedil|caron);/i','\1', $string);
        $string = html_entity_decode($string,ENT_COMPAT, "UTF-8"); 
        $string = preg_replace('/[^a-z0-9-]+/i', '-', $string);
        $string = preg_replace('/-+/', '-', $string);
        $string = trim($string, '-');

        $slug = strtolower($string);

        return $slug;
    }
}

if (! function_exists('languages'))
{
    function languages(){
        return LocaleLanguage::where('active', 1)->get();
    }
}

if ( ! function_exists('remove_protocol'))
{
    function remove_protocol($string)
    {
        if(stripos($string, 'https://') !== false){
            $string =  ltrim($string, 'https://');
        }

        else if(stripos($string, 'http://') !== false){
            $string =  ltrim($string, 'http://');
        }

        return $string;
    }
}

// if ( ! function_exists('display_menu'))
// {
//     function display_menu($menu_name)
//     {
//         $menu = new FrontMenuController();

//         return $menu->displayMenu($menu_name);
//     }
// }

