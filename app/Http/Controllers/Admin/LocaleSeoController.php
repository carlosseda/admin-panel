<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\Models\LocaleLanguage;
use App\Vendor\Locale\Manager;
use App\Vendor\Locale\Models\Sitemap;
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
    
    function __construct(Agent $agent, Manager $manager, LocaleLanguage $language, Sitemap $sitemap, LocaleSeo $seo, LocaleRedirect $locale_redirect, Googlebot $googlebot)
    {
        $this->middleware('auth');
        $this->agent = $agent;
        $this->manager = $manager;
        $this->language = $language;
        $this->sitemap = $sitemap;
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
        $seos = $this->seo
                ->select('key')
                ->groupBy('key')
                ->paginate($this->paginate);  

        $view = View::make('admin.seo.index')->with('seos', $seos);

        if(request()->ajax()) {

            $sections = $view->renderSections(); 

            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }

        return $view;
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
                    'redirection' => request('seo')['old_url.'.  $language] != request('seo')['url.'.  $language] ? 1 : 0,
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
            }
        }

        $this->manager->exportTranslations('routes');   

        $seos = $this->seo
                ->select('key')
                ->groupBy('key')
                ->paginate($this->paginate);  

        $message = \Lang::get('admin/seo.seo-update');
       
        $view = View::make('admin.seo.index')
        ->with('seos', $seos);
        
        if(request()->ajax()) {
            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
                'message' => $message,
            ]); 
        }
    }

    public function edit($key)
    {
    
        $seos = $this->seo->where('key', $key)->paginate($this->paginate); 

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
        ->with('seos', $seos)
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

    public function importSeo()
    {
        $this->manager->importTranslations();  
        $message =  \Lang::get('admin/seo.seo-import');

        $seos = $this->seo
            ->select('key')
            ->groupBy('key')
            ->paginate($this->paginate); 

        $view = View::make('admin.seo.index')->with('seos', $seos);

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

    public function getSitemaps()
    {

        $sitemap = $this->createSitemaps();

        $this->googlebot::create([
            'action' => 'deliver',
            'sitemap_id' => $sitemap['id'],
            'complete' => 1,
        ]);

        $this->seo->where('redirection', 1)->update(array('redirection' => 0 ));
        $this->locale_redirect->truncate();

        if(request()->ajax()) {
    
            return response()->json([
                'sitemap' => $sitemap['xml']
            ]); 
        }
    }

    public function createSitemaps()
    {
        $routes = Route::getRoutes();
        $routes->getByName('seo_import')->getController()->importSeo(); 

        $normalTimeLimit = ini_get('max_execution_time');
        ini_set('max_execution_time', 600); 

        $urlset = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"/>');
        $custom_sitemaps = collect();
        $rgx_parameters = '/\{.*?\}/';

        $total_pages = 0;
        $sitemaps = LocaleSeo::where('sitemap', 1)->get();

        foreach ($sitemaps as $sitemap){

            preg_match_all($rgx_parameters, $sitemap->url, $parameters);
            
            if(count($parameters[0]) > 0){

                $pages = $sitemap->slugs()->get();
                
                if(count($pages) > 0){

                    foreach($pages as $page){
                        $collection[] = str_replace('{slug}', $page->slug, $sitemap->url);
                    }
                    
                    foreach($collection as $url){               

                        $xml_url = $urlset->addChild('url');
                        $xml_url->addChild('loc', secure_url('/') . '/' . $sitemap->language . '/' . $url );
                        $xml_url->addChild('lastmod',$sitemap->updated_at->format("Y-m-d"));
                        $xml_url->addChild('changefreq', $sitemap->changefreq);  
                        $xml_url->addChild('priority', $sitemap->priority);

                        $total_pages++;
                    }
                }
            }

            else{

                $xml_url = $urlset->addChild('url');
                $xml_url->addChild('loc', secure_url('/') . '/' . $sitemap->language . '/' . $sitemap->url);
                $xml_url->addChild('lastmod', $sitemap->updated_at->format("Y-m-d"));
                $xml_url->addChild('changefreq', $sitemap->changefreq);  
                $xml_url->addChild('priority', $sitemap->priority);

                $total_pages++;
            }
        }

        $dom = new \DomDocument();
        $dom->loadXML($urlset->asXML());
        $dom->formatOutput = true;
        $xml_string = $dom->saveXML();
       
        $sitemapDB = $this->sitemap::create([
            'pages' => $total_pages,
        ]);

        $sitemap['id'] = $sitemapDB->id;

        Storage::disk('public_sitemap')->put($sitemap['id'] .'/sitemap.xml', $xml_string);

        $sitemap['xml'] = Storage::disk('public_sitemap')->get($sitemap['id'] . '/sitemap.xml');

        ini_set('max_execution_time', $normalTimeLimit);

        return $sitemap;
    }
}
