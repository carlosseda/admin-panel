<?php

namespace App\Vendor\Locale\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class LocaleSlugSeo extends Model
{
    protected $table = 't_locale_slug_seo';
    protected $guarded = [];

    public function locale_seo()
    {
        return $this->belongsTo(LocaleSeo::class, 'locale_seo_id');
    }

    public function parents()
    {
        return $this->belongsTo(LocaleSlugSeo::class, 'parent_slug')->with('parents');
    }

    public function scopeGetValues($query, $rel_parent, $key){
        
        return $query->where('key', $key)
            ->where('rel_parent', $rel_parent);
    }

    public function scopeGetAll($query){
        return $query->with('locale_seo');
    }

    public function scopeGetIdByLanguage($query, $rel_parent, $language, $slug){
        
        return $query->where('slug', $slug)
            ->where('language', $language)
            ->where('rel_parent', $rel_parent);
    }

    public function scopeGetIdByKey($query, $rel_parent, $language, $key){ 
        return $query->where('rel_parent', $rel_parent)
            ->where('language', $language)
            ->where('key', $key);
    }

    public function scopeGetByKey($query, $language, $key){ 
        return $query->where('language', $language)
            ->where('key', $key);
    }

    public function scopeGetLanguageByKey($query, $language, $key){ 
        return $query->where('language', $language)
            ->where('key', $key);
    }

    public function scopeGetKeyBySlug($query, $slug){ 
        return $query->where('slug', $slug);
    }

    public function scopeGetSectionsParameters($query, $rel_parent, $language){

        return $query->where('language', $language)
            ->where('rel_parent', $rel_parent)
            ->where('slug', '!=' , null);
    }

}
