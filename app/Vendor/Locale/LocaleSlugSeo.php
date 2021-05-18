<?php

namespace App\Vendor\Locale;

use App\Vendor\Locale\Models\LocaleSlugSeo as DBLocaleSlugSeo;
use App\Vendor\Locale\Models\LocaleSeo as DBLocaleSeo;

class LocaleSlugSeo
{
    protected $rel_parent;
    protected $language;
    protected $locale_seo;
    protected $locale_slug_seo;

    function __construct(DBLocaleSeo $locale_seo, DBLocaleSlugSeo $locale_slug_seo)
    {
        $this->locale_seo = $locale_seo;
        $this->locale_slug_seo = $locale_slug_seo;
    }

    public function setParent($rel_parent)
    {
        $this->rel_parent = $rel_parent;
    }

    public function getParent()
    {
        return $this->rel_parent;
    }

    public function setLanguage($language)
    {
        $this->language = $language;
    }

    public function create()
    {
        return new DBLocaleSlugSeo();
    }

    public function store($seo, $key, $locale_key)
    {  

        $locale_seo = $this->locale_seo->where('key', $locale_key)->first();

        foreach ($seo as $rel_anchor => $value){

            $rel_anchor = str_replace(['-', '_'], ".", $rel_anchor); 
            $explode_rel_anchor = explode('.', $rel_anchor);
            $language = end($explode_rel_anchor);

            $locale_slug_seo[] = $this->locale_slug_seo::updateOrCreate([
                'language' => $language,
                'rel_parent' => $this->rel_parent,
                'key' => $key],[
                'parent_slug' => isset($seo['parent.'. $language]) ? $seo['parent.'. $language] : null,
                'locale_seo_id' => $locale_seo->id,
                'slug' => slug_helper($seo['title.'. $language]),
                'title' => $seo['title.'. $language] ,
                'description' => isset($seo['description.'. $language])? $seo['description.'. $language] : '' ,
                'keywords' => isset($seo['keywords.'. $language])? $seo['keywords.'. $language] : '' ,
            ]);
        }

        foreach($locale_slug_seo as $value){
            $seo['title.'.$value->language] = $value->title;
            $seo['description.'.$value->language] = $value->description;
            $seo['keywords.'.$value->language] = $value->keywords;
        }

        return $seo;
    }

    public function show($key)
    {
        $seo = null;
        $values =  DBLocaleSlugSeo::getValues($this->rel_parent, $key)->get();   

        foreach($values as $value){
            $seo['title.'.$value->language] = $value->title;
            $seo['description.'.$value->language] = $value->description;
            $seo['keywords.'.$value->language] = $value->keywords;
        }

        return $seo;
    }

    public function delete($key)
    {
        if (DBLocaleSlugSeo::getValues($this->rel_parent, $key)->count() > 0) {

            DBLocaleSlugSeo::getValues($this->rel_parent, $key)->delete();   
        }
    }

    public function getAll(){ 
        return  DBLocaleSlugSeo::getAll()->get();
    }

    public function getIdByLanguage($slug){ 

        return  DBLocaleSlugSeo::getIdByLanguage($this->rel_parent, $this->language, $slug)->first();
    }

    public function getIdByKey($rel_parent, $language, $key){ 
        return  DBLocaleSlugSeo::getIdByKey($rel_parent, $language, $key)->first()->id;
    }

    public function getByKey($key){ 
        return  DBLocaleSeo::getByKey($this->language, $key)->first();
    }
}
    

