<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\DB\BusinessInformation; 

class AboutUsController extends Controller
{
    protected $agent;
    protected $business;
    protected $locale_slug_seo;

    function __construct(BusinessInformation $business, Agent $agent, LocaleSlugSeo $locale_slug_seo)
    {
        $this->agent = $agent;
        $this->business = $business;
        $this->locale_slug_seo = $locale_slug_seo;

        $this->locale_slug_seo->setLanguage(app()->getLocale()); 
        $this->locale_slug_seo->setParent('about_us');      
    }

    public function index()
    {        
        $seo = $this->locale_slug_seo->getByKey(Route::currentRouteName());

        $view = View::make('front.pages.about_us.index')
            ->with('seo', $seo )
            ->with('business', $this->business->first());
        
        return $view;
    }
}
