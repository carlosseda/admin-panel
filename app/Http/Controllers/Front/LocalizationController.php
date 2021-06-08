<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Vendor\Locale\LocalizationSeo;
use App\Vendor\Locale\LocaleSlugSeo;
use App;

class LocalizationController extends Controller
{
    protected $locale_slug_seo;

    function __construct(LocalizationSeo $locale_seo, LocaleSlugSeo $locale_slug_seo)
    {
        $this->locale_slug_seo = $locale_slug_seo;     
    }

    public function show($language, $parent, $slug = null)
    {
        $this->locale_slug_seo->setLanguage($language); 

        $locale_slug_seo = $this->locale_slug_seo->getByKey($parent);

        if(str_contains($locale_slug_seo->url, 'slug')){

            $key = $this->locale_slug_seo->getKeyBySlug($slug);
            $current_slug = $this->locale_slug_seo->getLanguageByKey($key);

            $url = '/'.$language . '/' . str_replace('{slug}', $current_slug->slug, $locale_slug_seo->url);

        }else{
            $url = '/'.$language . '/' . $locale_slug_seo->url;
        }

        return redirect($url);
    }
}