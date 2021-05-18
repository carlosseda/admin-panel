<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\Models\LocaleLanguage;
use App\Vendor\Locale\Manager;
use App\Vendor\Locale\Models\LocaleSeo;
use App\Vendor\Locale\Models\LocaleRedirect;
use App\Vendor\Locale\Models\Googlebot;

class LocaleSeoController extends Controller
{
    protected $agent;
    protected $manager;
    protected $language;
    protected $seo;
    protected $locale_redirect;
    protected $googlebot;
    protected $paginate;
    
    function __construct(Manager $manager, LocaleLanguage $language, LocaleSeo $seo, LocaleRedirect $locale_redirect, Googlebot $googlebot)
    {
        $this->middleware('auth');
        $this->agent = $agent;
        $this->manager = $manager;
        $this->language = $language;
        $this->seo = $seo;
        $this->locale_redirect = $locale_redirect;
        $this->googlebot = $googlebot;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }
    }

    public function index()
    {

        $view = View::make('admin.seo.index')
        ->with('seo', $this->seo)
        ->with('faqs', $this->faq->where('active', 1)
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
        $view = View::make('admin.seo.index')
        ->with('seo', $this->seo)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(Request $request)
    {      
     
        $languages = $this->language->get();

        foreach ($languages as $language){

            $language = $language->alias;

            if(isset(request('seo')['url.'. $language])){

                $locale_seo = $this->seo::updateOrCreate([
                    'language' => $language,
                    'group' =>request('seo')['group.'. $language],
                    'key' => request('seo')['key.'. $language]],[
                    'url' => request('seo')['url.'. $language],
                    'redirection' => request('seo')['old_url.'.  $language] != request('locale')['url.'.  $language] ? 1 : 0,
                    'title' => request('seo')['title.'.  $language],
                    'description' => request('seo')['description.'.  $language],
                    'keywords' => request('seo')['keywords.'.  $language],
                ]);
    
                if($locale_seo->redirection == 1){
    
                    $locale_redirect =  $this->locale_redirect::create([
                        'old_url' => request('seo')['old_url.'. $language],
                        'language' => $language,
                        'group' => $locale_seo->group,
                        'key' => $locale_seo->key,
                        'subdomain' => $locale_seo->subdomain,
                        'locale_seo_id' => $locale_seo->id,
                    ]);
                }

                $seos = $this->seo->where('key', $locale_seo->key)->get();

                $locale = $seos->filter(function($item) use($language) {
                    return $item->language == $language;
                })->first();
    
                $seo['url.'. $language] = empty($locale->url) ? '': $locale->url; 
                $seo['description.'. $language] = empty($locale->description) ? '': $locale->description; 
                $seo['keywords.'. $language] = empty($locale->keywords) ? '': $locale->keywords; 
                $seo['key.'. $language] = empty($locale->key) ? '': $locale->key;
                $seo['group.'. $language] = empty($locale->group) ? '': $locale->group; 
            }
        }

        $this->manager->exportTranslations('routes');   

        if (request('id')){
            $message = \Lang::get('admin/seo.seo-update');
        }else{
            $message = \Lang::get('admin/seo.seo-create');
        }
 
        $view = View::make('admin.seo.index')
        ->with('seo', $seo);
        
        if(request()->ajax()) {
            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'id' => $seo->id,
                'message' => $message,
            ]); 
        }
    }

    public function show(LocaleSeo $seo)
    {
        
        $seos = $this->seo->where('key', $seo->key)->get();

        $languages = $this->language->get();

        foreach($languages as $language){
            $locale = $seos->filter(function($item) use($language) {
                return $item->language == $language->alias;
            })->first();

            $seo['url.'. $language->alias] = empty($locale->url) ? '': $locale->url; 
            $seo['title.'. $language->alias] = empty($locale->title) ? '': $locale->title; 
            $seo['description.'. $language->alias] = empty($locale->description) ? '': $locale->description; 
            $seo['keywords.'. $language->alias] = empty($locale->keywords) ? '': $locale->keywords; 
            $seo['key.'. $language->alias] = empty($locale->key) ? '': $locale->key;
            $seo['group.'. $language->alias] = empty($locale->group) ? '': $locale->group; 
        }

        $view = View::make('admin.seo.index')
        ->with('seo', $seo);
        
        if(request()->ajax()) {
            $sections = $view->renderSections(); 
    
            return response()->json([
                'layout' => $sections['content'],
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy()
    {
       
    }

    public function importSeo()
    {
        $this->manager->importTranslations();  
        $message =  \Lang::get('admin/seo.seo-import');

        $seo = $this->seo->where('group', 'not like', 'admin/%')->orderBy('id', 'desc')->first();
        $seos = null;
        $locale = null;

        if(isset($seo)){
            $seos = $this->seo->where('key', $seo->key)->get();
            $seos->key = $seo->key;
            $seos->group = $seo->group;
            $seos->id = $seo->id;

            $languages = $this->language->get();

            foreach($languages as $language){
                $seo = $seos->filter(function($item) use($language) {
                    return $item->language == $language->alias;
                })->first();

                $locale['value.'. $language->alias] = empty($tag->value) ? '': $tag->value; 
            }
        }

        $view = View::make('admin.seo.index')
            ->with('locale', $locale)
            ->with('seo', $seo);

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'message' => $message,
            ]); 
        }
    }

    public function pingGoogle()
    {
        $url = 'http://www.google.com/ping?sitemap=' . secure_url('/') . '/' . 'sitemap.xml';

        $ch = curl_init($url);  
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);  
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
        $data = curl_exec($ch);  
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);  
        curl_close($ch);  

        if($httpcode>=200 && $httpcode<300){  
            $this->googlebot::create([
                'action' => 'call',
                'sitemap_id' => null,
                'complete' => 1,
            ]);

            $message = \Lang::get('admin/seo.seo-google-ok');

        } else {  
            $this->googlebot::create([
                'action' => 'call',
                'sitemap_id' => null,
                'complete' => 0,
            ]);

            $message = \Lang::get('admin/seo.seo-google-ko');
        }

        if(request()->ajax()) {
    
            return response()->json([
                'message' => $message,
            ]); 
        }
    }
}
