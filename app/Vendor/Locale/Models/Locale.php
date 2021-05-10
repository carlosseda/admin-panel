<?php

namespace App\Vendor\Locale\Models;

use Illuminate\Database\Eloquent\Model;
use Debugbar;

class Locale extends Model
{
    protected $table = 't_locale';
    protected $guarded = [];

    public function scopeGetValues($query, $rel_parent, $key){
        
        return $query->where('key', $key)
            ->where('rel_parent', $rel_parent);
    }

    public function scopeGetIdByLanguage($query, $rel_parent, $language, $key){
        
        return $query->where('key', $key)
            ->where('language', $language)
            ->where('rel_parent', $rel_parent);
    }

    public function scopeGetAllByLanguage($query, $rel_parent, $language){
        
        return $query->where('language', $language)
            ->where('rel_parent', $rel_parent);
    }

    public function scopeUpdateRelParent($query, $older_parent, $new_parent){ 
        return $query->where('rel_parent', $older_parent)
            ->update(['rel_parent' => $new_parent]);
    }
}
