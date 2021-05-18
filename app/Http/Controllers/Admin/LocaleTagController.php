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

    function __construct(LocaleTag $locale_tag, LocaleLanguage $language, Manager $manager)
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

        $tag = $this->locale_tag->where('group', 'not like', 'admin/%')->orderBy('id', 'desc')->first();
        $tags = null;
        $locale = null;

        if(isset($tag)){
            $tags = $this->locale_tag->where('key', $tag->key)->get();
            $tags->key = $tag->key;
            $tags->group = $tag->group;
            $tags->id = $tag->id;

            $languages = $this->language->get();

            foreach($languages as $language){
                $tag = $tags->filter(function($item) use($language) {
                    return $item->language == $language->alias;
                })->first();

                $locale['value.'. $language->alias] = empty($tag->value) ? '': $tag->value; 
            }
        }

        $view = View::make('admin.tags.index')
            ->with('locale', $locale)
            ->with('tags', $tags);

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

    }

    public function store(Request $request)
    {    
    
        foreach (request('locale') as $rel_anchor => $value){

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
                'value' => $value
            ]);
        }

        $tags = $this->locale_tag->where('key', $locale_tag->key)->get();
        $tags->key = $locale_tag->key;
        $tags->group = $locale_tag->group;
        $tags->id = $locale_tag->id;

        $this->manager->exportTranslations(request('group'));   

        $message = \Lang::get('admin/tags.tag-update');

        $view = View::make('admin.tags.index')
        ->with('tags', $tags)
        ->with('locale', $locale_tag)
        ->renderSections(); 

        return response()->json([
            'table' => $view['table'],
            'id' => $locale_tag->id,
            'message' => $message,
        ]);
    }

    public function show(LocaleTag $tag)
    {

        $tags = $this->locale_tag->where('key', $tag->key)->get();
        $tags->key = $tag->key;
        $tags->group = $tag->group;
        $tags->id = $tag->id;

        $languages = $this->language->get();

        foreach($languages as $language){
            $tag = $tags->filter(function($item) use($language) {
                return $item->language == $language->alias;
            })->first();

            $locale['value.'. $language->alias] = empty($tag->value) ? '': $tag->value; 
        }
        
        $view = View::make('admin.tags.index')
        ->with('locale', $locale)
        ->with('tags', $tags);
        
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

    public function importTags()
    {
        $this->manager->importTranslations();  
        $message =  \Lang::get('admin/tags.tag-import');

        $tag = $this->locale_tag->where('group', 'not like', 'admin/%')->orderBy('id', 'desc')->first();
        $tags = null;
        $locale = null;

        if(isset($tag)){
            $tags = $this->locale_tag->where('key', $tag->key)->get();
            $tags->key = $tag->key;
            $tags->group = $tag->group;
            $tags->id = $tag->id;

            $languages = $this->language->get();

            foreach($languages as $language){
                $tag = $tags->filter(function($item) use($language) {
                    return $item->language == $language->alias;
                })->first();

                $locale['value.'. $language->alias] = empty($tag->value) ? '': $tag->value; 
            }
        }

        $view = View::make('admin.tags.index')
            ->with('locale', $locale)
            ->with('tags', $tags);

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'topbar' => $topbar,
                'table' => $sections['table'],
                'message' => $message,
            ]); 
        }
    }
}
