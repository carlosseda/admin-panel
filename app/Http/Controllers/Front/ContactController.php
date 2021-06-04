<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\DB\ContactLog;

class ContactController extends Controller
{
    protected $agent;
    protected $contact;
    protected $locale_slug_seo;

    function __construct(Agent $agent, ContactLog $contact_log, LocaleSlugSeo $locale_slug_seo)
    {
        $this->agent = $agent;
        $this->contact_log = $contact_log;
        $this->locale_slug_seo = $locale_slug_seo;

        $this->locale_slug_seo->setLanguage(app()->getLocale()); 
        $this->locale_slug_seo->setParent('contact');      
    }

    public function index()
    {        
        $seo = $this->locale_slug_seo->getByKey(Route::currentRouteName());

        $view = View::make('front.pages.contact.index')->with('seo', $seo );
        
        return $view;
    }

    public function show($slug)
    {      
        $seo = $this->locale_slug_seo->getIdByLanguage($slug);

        if(isset($seo->key)){

            if($this->agent->isDesktop()){
                $faq = $this->faq
                    ->with('image_featured_desktop')
                    ->with('image_grid_desktop')
                    ->where('active', 1)
                    ->where('visible', 1)
                    ->find($seo->key);
            }
            
            elseif($this->agent->isMobile()){
                $faq = $this->faq
                    ->with('image_featured_mobile')
                    ->with('image_grid_mobile')
                    ->where('active', 1)
                    ->where('visible', 1)
                    ->find($seo->key);
            }

            $faq['locale'] = $faq->locale->pluck('value','tag');

            $view = View::make('front.pages.faqs.single')->with('faq', $faq);

            return $view;

        }else{
            return response()->view('errors.404', [], 404);
        }
    }
}
