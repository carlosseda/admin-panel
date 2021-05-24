<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\Manager;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Models\LocaleLanguage;
use App\Vendor\Locale\Models\LocaleTag;

class LocaleTagController extends Controller 
{
    protected $agent;
    protected $locale_tag;
    protected $language;
    protected $manager;
    protected $paginate;

    function __construct(Agent $agent, LocaleTag $locale_tag, LocaleLanguage $language, Manager $manager)
    {
        $this->middleware('auth');
        $this->agent = $agent;
        $this->locale_tag = $locale_tag;
        $this->language = $language;
        $this->manager = $manager;
        $this->locale_tag->active = 1;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }
    }

    public function index()
    {
        $tags = $this->locale_tag
                ->select('group', 'key')
                ->groupBy('group', 'key')
                ->where('group', 'not like', 'admin/%')
                ->where('group', 'not like', 'front/seo')
                ->paginate($this->paginate);         

        $view = View::make('admin.tags.index')
            ->with('tags',  $tags)
            ->with('tag', $this->locale_tag);
  
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
    
        foreach (request('tag') as $rel_anchor => $value){

            $rel_anchor = str_replace(['-', '_'], ".", $rel_anchor); 
            $explode_rel_anchor = explode('.', $rel_anchor);
            $language = end($explode_rel_anchor);

            $locale_tag = $this->locale_tag::updateOrCreate([
                'language' => $language,
                'group' => request('group'),
                'key' => request('key')],[
                'language' => $language,
                'group' => request('group'),
                'key' => request('key'),
                'value' => $value,
                'active' => 1
            ]);
        }
        
        $this->manager->exportTranslations(request('group'));   

        $tags = $this->locale_tag
        ->select('group', 'key')
        ->groupBy('group', 'key')
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->paginate($this->paginate);  

        $message = \Lang::get('admin/tags.tag-update');

        $view = View::make('admin.tags.index')
        ->with('tags', $tags)
        ->with('tag', $this->locale_tag)
        ->renderSections(); 

        return response()->json([
            'table' => $view['table'],
            'message' => $message,
        ]);
    }

    public function edit($group, $key)
    {

        $tags = $this->locale_tag->where('key', $key)->where('group', str_replace('-', '/' , $group))->paginate($this->paginate); 
        $tag = $tags->first();

        $languages = $this->language->get();

        foreach($languages as $language){
            $locale = $tags->filter(function($item) use($language) {
                return $item->language == $language->alias;
            })->first();

            $tag['value.'. $language->alias] = empty($locale->value) ? '': $locale->value; 
        }
        
        $view = View::make('admin.tags.index')
        ->with('tags', $tags)
        ->with('tag', $tag);
        
        if(request()->ajax()) {
            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function importTags()
    {
        $this->manager->importTranslations();  
        $message =  \Lang::get('admin/tags.tag-import');

        $tags = $this->locale_tag
        ->select('group', 'key')
        ->groupBy('group', 'key')
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->paginate($this->paginate);  

        $view = View::make('admin.tags.index')
            ->with('tags', $tags)
            ->with('tag', $this->locale_tag);

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'message' => $message,
            ]); 
        }
    }
}
