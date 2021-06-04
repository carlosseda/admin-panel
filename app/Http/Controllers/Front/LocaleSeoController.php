<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Models\LocaleSeo;
use App\Vendor\Locale\Models\LocaleRedirect;
use App\Vendor\Locale\Models\Sitemap;
use App\Vendor\Locale\Models\Googlebot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Route;

class LocaleSeoController extends Controller
{
    protected $locale_seo;
    protected $locale_redirection;
    protected $sitemap;
    protected $googlebot;

    public function __construct(LocaleSeo $locale_seo, LocaleRedirect $locale_redirect, Sitemap $sitemap, Googlebot $googlebot)
    {
        $this->locale_seo = $locale_seo;
        $this->locale_redirect = $locale_redirect;
        $this->sitemap = $sitemap;
        $this->googlebot = $googlebot;
    }

    public function getSitemaps(Request $request)
    {

        $sitemap = $this->createSitemaps();

        $this->googlebot::create([
            'action' => 'deliver',
            'sitemap_id' => $sitemap['id'],
            'complete' => 1,
        ]);

        $this->locale_seo->where('redirection', 1)->update(array('redirection' => 0 ));
        $this->locale_redirect->truncate();

        if(strpos($request->header('User-Agent'), 'Googlebot') === true){
            
            return $sitemap['xml'];

        }else{

            $view = View::make('admin.components.sitemap')
            ->with('sitemap', $sitemap['xml']);
                    
            return $view;
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