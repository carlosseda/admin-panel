<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\DB\Faq;

class FaqController extends Controller
{
    protected $agent;
    protected $faq;
    protected $locale_slug_seo;

    function __construct(Agent $agent, Faq $faq, LocaleSlugSeo $locale_slug_seo)
    {
        $this->agent = $agent;
        $this->faq = $faq;
        $this->locale_slug_seo = $locale_slug_seo;

        $this->locale_slug_seo->setLanguage(app()->getLocale()); 
        $this->locale_slug_seo->setParent('faqs');      
    }

    public function index()
    {        
        $seo = $this->locale_slug_seo->getByKey(Route::currentRouteName());

        if($this->agent->isDesktop()){

            $faqs = $this->faq
                    ->with('image_featured_desktop')
                    ->where('active', 1)
                    ->where('visible', 1)
                    ->get();
        }
        
        elseif($this->agent->isMobile()){
            $faqs = $this->faq
                    ->with('image_featured_mobile')
                    ->where('active', 1)
                    ->where('visible', 1)
                    ->get();
        }

        $faqs = $faqs->each(function($faq){  
            
            $faq['locale'] = $faq->locale->pluck('value','tag');
            
            return $faq;
        });

        $view = View::make('front.pages.faqs.index')
                ->with('faqs', $faqs) 
                ->with('seo', $seo );
        
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
